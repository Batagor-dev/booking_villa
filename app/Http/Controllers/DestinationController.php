<?php

namespace App\Http\Controllers;

use App\DataTables\DestinationDataTable;
use App\Http\Requests\StoreDestinationRequest;
use App\Http\Requests\UpdateDestinationRequest;
use App\Models\Destination;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DestinationDataTable $dataTable)
    {
        return $dataTable->render('destination.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->data['action'] = route('destination.store');
        $this->data['nextSort'] = (Destination::max('sort') ?? 0) + 1;
        return view('destination.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDestinationRequest $request, ImageService $imageService)
    {
        $data = $request->validated();
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $compressed = $imageService->compress($file);
            $filename = 'destination-images/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filename, $compressed);
            $data['image_path'] = $filename;
        }

        Destination::create($data);

        return redirect()->route('destination.index')->with('success', 'Destination created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Destination $destination)
    {
        $this->data['destination_data'] = $destination;
        $this->data['action'] = route('destination.update', $destination->uuid);
        return view('destination.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDestinationRequest $request, Destination $destination, ImageService $imageService)
    {
        $data = $request->validated();
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($destination->image_path && !str_starts_with($destination->image_path, 'http') && Storage::disk('public')->exists($destination->image_path)) {
                Storage::disk('public')->delete($destination->image_path);
            }

            $file = $request->file('image');
            $compressed = $imageService->compress($file);
            $filename = 'destination-images/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filename, $compressed);
            $data['image_path'] = $filename;
        }

        $destination->update($data);

        return redirect()->route('destination.index')->with('success', 'Destination updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Destination $destination)
    {
        if ($destination->image_path && !str_starts_with($destination->image_path, 'http') && Storage::disk('public')->exists($destination->image_path)) {
            Storage::disk('public')->delete($destination->image_path);
        }

        $destination->delete();

        return redirect()->route('destination.index')->with('success', 'Destination deleted successfully!');
    }
}
