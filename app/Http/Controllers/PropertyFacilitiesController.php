<?php

namespace App\Http\Controllers;

use App\DataTables\PropertyFacilityDataTable;
use App\Http\Requests\StorePropertyFacilityRequest;
use App\Http\Requests\UpdatePropertyFacilityRequest;
use App\Models\PropertyFacilities;
use App\Models\Properties;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;

class PropertyFacilitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PropertyFacilityDataTable $dataTable)
    {
        return $dataTable->render('facility.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->data['properties'] = Properties::all();
        $this->data['action'] = route('property_facilities.store');
        return view('facility.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePropertyFacilityRequest $request, ImageService $imageService)
    {
        $data = $request->validated();
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $compressed = $imageService->compress($file);
            $filename = 'facility-images/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filename, $compressed);
            $data['image_path'] = $filename;
        }

        PropertyFacilities::create($data);

        return redirect()->route('property_facilities.index')->with('success', 'Property Facility created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PropertyFacilities $property_facility)
    {
        $this->data['facility_data'] = $property_facility;
        $this->data['properties'] = Properties::all();
        $this->data['action'] = route('property_facilities.update', $property_facility->uuid);
        return view('facility.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePropertyFacilityRequest $request, PropertyFacilities $property_facility, ImageService $imageService)
    {
        $data = $request->validated();
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($property_facility->image_path && Storage::disk('public')->exists($property_facility->image_path)) {
                Storage::disk('public')->delete($property_facility->image_path);
            }

            $file = $request->file('image');
            $compressed = $imageService->compress($file);
            $filename = 'facility-images/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filename, $compressed);
            $data['image_path'] = $filename;
        }

        $property_facility->update($data);

        return redirect()->route('property_facilities.index')->with('success', 'Property Facility updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PropertyFacilities $property_facility)
    {
        if ($property_facility->image_path && Storage::disk('public')->exists($property_facility->image_path)) {
            Storage::disk('public')->delete($property_facility->image_path);
        }

        $property_facility->delete();

        return redirect()->route('property_facilities.index')->with('success', 'Property Facility deleted successfully!');
    }
}
