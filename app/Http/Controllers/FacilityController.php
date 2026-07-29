<?php

namespace App\Http\Controllers;

use App\DataTables\FacilityDataTable;
use App\Http\Requests\StoreFacilityRequest;
use App\Http\Requests\UpdateFacilityRequest;
use App\Models\Facilities;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FacilityDataTable $dataTable)
    {
        return $dataTable->render('facility.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->data['action'] = route('facilities.store');
        return view('facility.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFacilityRequest $request, ImageService $imageService)
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

        Facilities::create($data);

        return redirect()->route('facilities.index')->with('success', 'Master Facility created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facilities $facility)
    {
        $this->data['facility_data'] = $facility;
        $this->data['action'] = route('facilities.update', $facility->uuid);
        return view('facility.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFacilityRequest $request, Facilities $facility, ImageService $imageService)
    {
        $data = $request->validated();
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($facility->image_path && Storage::disk('public')->exists($facility->image_path)) {
                Storage::disk('public')->delete($facility->image_path);
            }

            $file = $request->file('image');
            $compressed = $imageService->compress($file);
            $filename = 'facility-images/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filename, $compressed);
            $data['image_path'] = $filename;
        }

        $facility->update($data);

        return redirect()->route('facilities.index')->with('success', 'Master Facility updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facilities $facility)
    {
        if ($facility->image_path && Storage::disk('public')->exists($facility->image_path)) {
            Storage::disk('public')->delete($facility->image_path);
        }

        $facility->delete();

        return redirect()->route('facilities.index')->with('success', 'Master Facility deleted successfully!');
    }
}
