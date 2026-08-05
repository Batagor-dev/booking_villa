<?php

namespace App\Http\Controllers;

use App\DataTables\PropertyDataTable;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Models\Properties;
use App\Models\PropertySettings;
use App\Models\PropertyGallery;
use App\Models\Facilities;
use App\Models\Destination;
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
        $this->data['destinations'] = Destination::where('status', true)->orderBy('sort')->get();
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

            // Auto generate max 3-character code from property name initials
            $cleanText = preg_replace('/[^a-zA-Z0-9\s]/', '', $data['name']);
            $words = array_values(array_filter(explode(' ', trim($cleanText))));
            $codeResult = '';

            if (count($words) >= 3) {
                $codeResult = substr($words[0], 0, 1) . substr($words[1], 0, 1) . substr($words[2], 0, 1);
            } elseif (count($words) === 2) {
                $codeResult = substr($words[0], 0, 1) . (strlen($words[1]) >= 2 ? substr($words[1], 0, 2) : $words[1]);
            } elseif (count($words) === 1) {
                $codeResult = substr($words[0], 0, 3);
            }
            $data['code'] = strtoupper($codeResult);

            // Auto format map_link into embed iframe if user pasted short link or URL
            if (!empty($data['map_link'])) {
                $data['map_link'] = $this->formatMapLinkToIframe($data['map_link']);
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
        $property->load(['settings', 'galleries', 'facilities', 'destination']);
        $this->data['property_data'] = $property;
        $this->data['destinations'] = Destination::where('status', true)->orderBy('sort')->get();
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

            // Auto generate max 3-character code from property name initials
            $cleanText = preg_replace('/[^a-zA-Z0-9\s]/', '', $data['name']);
            $words = array_values(array_filter(explode(' ', trim($cleanText))));
            $codeResult = '';

            if (count($words) >= 3) {
                $codeResult = substr($words[0], 0, 1) . substr($words[1], 0, 1) . substr($words[2], 0, 1);
            } elseif (count($words) === 2) {
                $codeResult = substr($words[0], 0, 1) . (strlen($words[1]) >= 2 ? substr($words[1], 0, 2) : $words[1]);
            } elseif (count($words) === 1) {
                $codeResult = substr($words[0], 0, 3);
            }
            $data['code'] = strtoupper($codeResult);

            // Auto format map_link into embed iframe if user pasted short link or URL
            if (!empty($data['map_link'])) {
                $data['map_link'] = $this->formatMapLinkToIframe($data['map_link']);
            }

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

    /**
     * Helper to format any URL or short link into a working Google Maps embed iframe string.
     */
    protected function formatMapLinkToIframe(?string $url): ?string
    {
        if (empty($url)) return null;

        $url = trim($url);

        // If already iframe tag, return as is
        if (str_contains($url, '<iframe')) {
            return $url;
        }

        $fullUrl = $url;
        // Resolve shortened URLs
        if (str_contains($url, 'goo.gl') || str_contains($url, 'maps.app.goo.gl')) {
            try {
                $headers = @get_headers($url, 1);
                if (isset($headers['Location'])) {
                    $fullUrl = is_array($headers['Location']) ? end($headers['Location']) : $headers['Location'];
                }
            } catch (\Exception $e) {}
        }

        $placeName = '';
        $lat = null;
        $lng = null;

        if (preg_match('/maps\/place\/([^\/@]+)/', $fullUrl, $m)) {
            $placeName = urldecode(str_replace('+', ' ', $m[1]));
        }

        if (preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+)/', $fullUrl, $m)) {
            $lat = $m[1];
            $lng = $m[2];
        }

        if ($placeName && $lat && $lng) {
            $query = urlencode($placeName) . "@{$lat},{$lng}";
        } elseif ($placeName) {
            $query = urlencode($placeName);
        } elseif ($lat && $lng) {
            $query = "{$lat},{$lng}";
        } else {
            $query = urlencode($fullUrl);
        }

        return '<iframe src="https://maps.google.com/maps?q=' . $query . '&t=&z=15&ie=UTF8&iwloc=&output=embed" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>';
    }

    /**
     * Resolve short Google Maps URL (e.g. maps.app.goo.gl) to embed iframe & location details.
     */
    public function resolveMapsUrl(\Illuminate\Http\Request $request)
    {
        $url = trim($request->input('url', ''));

        if (empty($url)) {
            return response()->json(['error' => 'URL Kosong'], 422);
        }

        // If it's already an iframe HTML tag
        if (str_contains($url, '<iframe')) {
            preg_match('/src=["\']([^"\']+)["\']/i', $url, $m);
            $embedUrl = $m[1] ?? '';
            return response()->json([
                'success' => true,
                'iframe' => $url,
                'embed_url' => $embedUrl,
                'direct_url' => $embedUrl,
            ]);
        }

        $fullUrl = $url;
        // Resolve shortened URLs (maps.app.goo.gl / goo.gl)
        if (str_contains($url, 'goo.gl') || str_contains($url, 'maps.app.goo.gl')) {
            try {
                $headers = @get_headers($url, 1);
                if (isset($headers['Location'])) {
                    $fullUrl = is_array($headers['Location']) ? end($headers['Location']) : $headers['Location'];
                }
            } catch (\Exception $e) {}
        }

        $placeName = '';
        $lat = null;
        $lng = null;

        // Try extracting place name from fullUrl
        if (preg_match('/maps\/place\/([^\/@]+)/', $fullUrl, $matches)) {
            $placeName = urldecode(str_replace('+', ' ', $matches[1]));
        }

        // Try extracting coordinates
        if (preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+)/', $fullUrl, $matches)) {
            $lat = $matches[1];
            $lng = $matches[2];
        }

        if (empty($placeName) && preg_match('/!3d(-?\d+\.\d+)!4d(-?\d+\.\d+)/', $fullUrl, $matches)) {
            $lat = $matches[1];
            $lng = $matches[2];
        }

        // Build query string for Google Maps embed with RED MARKER PIN
        if ($placeName && $lat && $lng) {
            $query = urlencode($placeName) . "@{$lat},{$lng}";
        } elseif ($placeName) {
            $query = urlencode($placeName);
        } elseif ($lat && $lng) {
            $query = "{$lat},{$lng}";
        } else {
            $query = urlencode($fullUrl);
        }

        $embedSrc = "https://maps.google.com/maps?q={$query}&t=&z=15&ie=UTF8&iwloc=&output=embed";
        $iframeHtml = '<iframe src="' . $embedSrc . '" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>';

        return response()->json([
            'success' => true,
            'iframe' => $iframeHtml,
            'embed_url' => $embedSrc,
            'direct_url' => $fullUrl,
            'place_name' => $placeName,
            'lat' => $lat,
            'lng' => $lng,
        ]);
    }
}
