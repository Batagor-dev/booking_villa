<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Banner;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Services\ImageService;
use App\DataTables\BannerDataTable;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BannerDataTable $dataTable)
    {
        return $dataTable->render('banner.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->data['action'] = "/banner";
        return view('banner.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBannerRequest $request, ImageService $imageService)
    {
        $data = $request->all();
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $compressed = $imageService->compress($file);
            $filename = 'banner-images/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filename, $compressed);
            $data['image_path'] = $filename;
        }

        Banner::create($data);

        return redirect('banner')->with('success', 'New banner has been created!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        $this->data['banner_data'] = $banner;
        $this->data['action'] = "/banner/" . $banner->uuid;
        $this->data['model'] = $banner;
        return view('banner.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBannerRequest $request, Banner $banner, ImageService $imageService)
    {
        $data = $request->all();
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($banner->image_path && Storage::disk('public')->exists($banner->image_path)) {
                Storage::disk('public')->delete($banner->image_path);
            }

            $file = $request->file('image');
            $compressed = $imageService->compress($file);
            $filename = 'banner-images/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filename, $compressed);
            $data['image_path'] = $filename;
        }

        $banner->update($data);

        return redirect()
            ->route('banner.index')
            ->with('success', 'Banner has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        if ($banner->image_path) {
            Storage::disk('public')->delete($banner->image_path);
        }

        $banner->delete();

        return redirect('/banner')->with('success', 'Banner has been deleted!');
    }
}
