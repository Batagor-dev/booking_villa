<?php

namespace App\Http\Controllers;

use App\DataTables\PropertyDataTable;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Models\Properties;
use App\Models\PropertySettings;
use App\Models\PropertyGallery;
use App\Models\Facilities;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PropertyDataTable $dataTable)
    {
        return $dataTable->render('property.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->data['facilities'] = Facilities::where('status', true)->orderBy('sort')->get();
        $this->data['action'] = route('properties.store');
        return view('property.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePropertyRequest $request, ImageService $imageService)
    {
        DB::transaction(function () use ($request, $imageService) {
            $data = $request->validated();
            $data['status'] = $request->has('status') ? 1 : 0;
            $data['is_featured'] = $request->has('is_featured') ? 1 : 0;

            // Auto generate 3-letter code if empty
            if (empty($data['code'])) {
                $cleanName = preg_replace('/[^A-Za-z]/', '', $data['name']);
                $code = strtoupper(substr($cleanName, 0, 3));
                $data['code'] = str_pad($code, 3, 'V');
            }

            // 1. Upload Cover Image
            if ($request->hasFile('main_image')) {
                $file = $request->file('main_image');
                $compressed = $imageService->compress($file);
                $filename = 'property-covers/' . uniqid() . '.jpg';
                Storage::disk('public')->put($filename, $compressed);
                $data['main_image'] = $filename;
            }

            // 2. Create Property
            $property = Properties::create($data);

            // 3. Sync Facilities
            if ($request->has('facilities')) {
                $property->facilities()->sync($request->facilities);
            }

            // 4. Create Property Settings
            $property->settings()->create([
                'check_in_time'       => $request->input('check_in_time', '14:00'),
                'check_out_time'      => $request->input('check_out_time', '12:00'),
                'cancellation_policy' => $request->input('cancellation_policy'),
                'phone'               => $request->input('phone'),
                'email'               => $request->input('email'),
                'currency'            => $request->input('currency', 'IDR'),
                'latitude'            => $request->input('latitude'),
                'longitude'           => $request->input('longitude'),
            ]);

            // 5. Upload Gallery Photos
            if ($request->hasFile('gallery_images')) {
                $sort = 1;
                foreach ($request->file('gallery_images') as $galleryFile) {
                    $compressed = $imageService->compress($galleryFile);
                    $filename = 'property-galleries/' . uniqid() . '.jpg';
                    Storage::disk('public')->put($filename, $compressed);

                    $property->galleries()->create([
                        'image_path' => $filename,
                        'sort'       => $sort++,
                    ]);
                }
            }
        });

        return redirect()->route('properties.index')->with('success', 'New Property has been created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Properties $property)
    {
        $property->load(['settings', 'galleries', 'facilities']);
        $this->data['property_data'] = $property;
        $this->data['facilities'] = Facilities::where('status', true)->orderBy('sort')->get();
        $this->data['selected_facilities'] = $property->facilities->pluck('id')->toArray();
        $this->data['action'] = route('properties.update', $property->slug);
        return view('property.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePropertyRequest $request, Properties $property, ImageService $imageService)
    {
        DB::transaction(function () use ($request, $property, $imageService) {
            $data = $request->validated();
            $data['status'] = $request->has('status') ? 1 : 0;
            $data['is_featured'] = $request->has('is_featured') ? 1 : 0;

            // 1. Cover Image Update
            if ($request->hasFile('main_image')) {
                if ($property->main_image && Storage::disk('public')->exists($property->main_image)) {
                    Storage::disk('public')->delete($property->main_image);
                }

                $file = $request->file('main_image');
                $compressed = $imageService->compress($file);
                $filename = 'property-covers/' . uniqid() . '.jpg';
                Storage::disk('public')->put($filename, $compressed);
                $data['main_image'] = $filename;
            }

            // 2. Update Main Property
            $property->update($data);

            // 3. Sync Facilities
            $property->facilities()->sync($request->input('facilities', []));

            // 4. Update Settings
            $property->settings()->updateOrCreate(
                ['property_id' => $property->id],
                [
                    'check_in_time'       => $request->input('check_in_time', '14:00'),
                    'check_out_time'      => $request->input('check_out_time', '12:00'),
                    'cancellation_policy' => $request->input('cancellation_policy'),
                    'phone'               => $request->input('phone'),
                    'email'               => $request->input('email'),
                    'currency'            => $request->input('currency', 'IDR'),
                    'latitude'            => $request->input('latitude'),
                    'longitude'           => $request->input('longitude'),
                ]
            );

            // 5. Delete specific gallery items if requested
            if ($request->has('delete_galleries')) {
                $galleriesToDelete = PropertyGallery::whereIn('id', $request->delete_galleries)->get();
                foreach ($galleriesToDelete as $galleryItem) {
                    if ($galleryItem->image_path && Storage::disk('public')->exists($galleryItem->image_path)) {
                        Storage::disk('public')->delete($galleryItem->image_path);
                    }
                    $galleryItem->delete();
                }
            }

            // 6. Upload New Gallery Photos
            if ($request->hasFile('gallery_images')) {
                $lastSort = $property->galleries()->max('sort') ?? 0;
                foreach ($request->file('gallery_images') as $galleryFile) {
                    $compressed = $imageService->compress($galleryFile);
                    $filename = 'property-galleries/' . uniqid() . '.jpg';
                    Storage::disk('public')->put($filename, $compressed);

                    $property->galleries()->create([
                        'image_path' => $filename,
                        'sort'       => ++$lastSort,
                    ]);
                }
            }
        });

        return redirect()->route('properties.index')->with('success', 'Property has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Properties $property)
    {
        DB::transaction(function () use ($property) {
            // Delete main image file
            if ($property->main_image && Storage::disk('public')->exists($property->main_image)) {
                Storage::disk('public')->delete($property->main_image);
            }

            // Delete gallery image files
            foreach ($property->galleries as $galleryItem) {
                if ($galleryItem->image_path && Storage::disk('public')->exists($galleryItem->image_path)) {
                    Storage::disk('public')->delete($galleryItem->image_path);
                }
            }

            $property->delete();
        });

        return redirect()->route('properties.index')->with('success', 'Property has been deleted successfully!');
    }
}
