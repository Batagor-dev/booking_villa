<?php

namespace App\Http\Controllers;

use App\DataTables\PropertyServiceDataTable;
use App\Http\Requests\StorePropertyServiceRequest;
use App\Http\Requests\UpdatePropertyServiceRequest;
use App\Models\PropertyServices;
use App\Models\Properties;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;

class PropertyServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PropertyServiceDataTable $dataTable)
    {
        return $dataTable->render('service.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->data['properties'] = Properties::all();
        $this->data['action'] = route('property_services.store');
        return view('service.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePropertyServiceRequest $request, ImageService $imageService)
    {
        $data = $request->validated();
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $compressed = $imageService->compress($file);
            $filename = 'service-images/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filename, $compressed);
            $data['image_path'] = $filename;
        }

        PropertyServices::create($data);

        return redirect()->route('property_services.index')->with('success', 'Property Service created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PropertyServices $property_service)
    {
        $this->data['service_data'] = $property_service;
        $this->data['properties'] = Properties::all();
        $this->data['action'] = route('property_services.update', $property_service->uuid);
        return view('service.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePropertyServiceRequest $request, PropertyServices $property_service, ImageService $imageService)
    {
        $data = $request->validated();
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($property_service->image_path && Storage::disk('public')->exists($property_service->image_path)) {
                Storage::disk('public')->delete($property_service->image_path);
            }

            $file = $request->file('image');
            $compressed = $imageService->compress($file);
            $filename = 'service-images/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filename, $compressed);
            $data['image_path'] = $filename;
        }

        $property_service->update($data);

        return redirect()->route('property_services.index')->with('success', 'Property Service updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PropertyServices $property_service)
    {
        if ($property_service->image_path && Storage::disk('public')->exists($property_service->image_path)) {
            Storage::disk('public')->delete($property_service->image_path);
        }

        $property_service->delete();

        return redirect()->route('property_services.index')->with('success', 'Property Service deleted successfully!');
    }
}
