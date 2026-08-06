<?php

namespace App\Http\Controllers;

use App\DataTables\PromotionDataTable;
use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;
use App\Models\Promotion;
use App\Models\Properties;
use App\Models\Destination;
use Illuminate\Support\Facades\DB;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PromotionDataTable $dataTable)
    {
        return $dataTable->render('promotion.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->data['action'] = route('promotion.store');
        $this->data['properties'] = Properties::where('status', true)->orderBy('name')->get();
        $this->data['destinations'] = Destination::where('status', true)->orderBy('name')->get();
        $this->data['propertyTypes'] = Properties::distinct()->pluck('type')->toArray();
        return view('promotion.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePromotionRequest $request)
    {
        DB::transaction(function () use ($request) {
            $data = $request->validated();
            $data['status'] = $request->has('status') ? 1 : 0;

            // Set times to exactly 12 AM (midnight)
            if (!empty($data['start_date'])) {
                $data['start_date'] = \Carbon\Carbon::parse($data['start_date'])->startOfDay();
            }
            if (!empty($data['end_date'])) {
                $data['end_date'] = \Carbon\Carbon::parse($data['end_date'])->startOfDay();
            }

            // If auto-applied, code should be null
            if ($data['promotion_type'] === 'automatic') {
                $data['code'] = null;
            }

            $promotion = Promotion::create($data);

            // Sync targets
            if ($promotion->target_type === 'properties' && $request->has('property_ids')) {
                $promotion->properties()->sync($request->property_ids);
            } elseif ($promotion->target_type === 'categories' && $request->has('property_types')) {
                $types = array_map(function ($type) {
                    return ['property_type' => $type];
                }, $request->property_types);
                $promotion->propertyTypes()->createMany($types);
            } elseif ($promotion->target_type === 'destinations' && $request->has('destination_ids')) {
                $promotion->destinations()->sync($request->destination_ids);
            }
        });

        return redirect()->route('promotion.index')->with('success', 'Promotion created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promotion $promotion)
    {
        $this->data['promotion_data'] = $promotion;
        $this->data['action'] = route('promotion.update', $promotion->id);
        
        $this->data['properties'] = Properties::where('status', true)->orderBy('name')->get();
        $this->data['destinations'] = Destination::where('status', true)->orderBy('name')->get();
        $this->data['propertyTypes'] = Properties::distinct()->pluck('type')->toArray();

        // Get currently selected target IDs/values
        $this->data['selectedProperties'] = $promotion->properties->pluck('id')->toArray();
        $this->data['selectedPropertyTypes'] = $promotion->propertyTypes->pluck('property_type')->toArray();
        $this->data['selectedDestinations'] = $promotion->destinations->pluck('id')->toArray();

        $this->data['discount_value_percentage'] = $promotion->discount_type === 'percentage' ? (int)$promotion->discount_value : '';
        $this->data['discount_value_fixed'] = $promotion->discount_type === 'fixed' ? (int)$promotion->discount_value : '';

        return view('promotion.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePromotionRequest $request, Promotion $promotion)
    {
        DB::transaction(function () use ($request, $promotion) {
            $data = $request->validated();
            $data['status'] = $request->has('status') ? 1 : 0;

            // Set times to exactly 12 AM (midnight)
            if (!empty($data['start_date'])) {
                $data['start_date'] = \Carbon\Carbon::parse($data['start_date'])->startOfDay();
            }
            if (!empty($data['end_date'])) {
                $data['end_date'] = \Carbon\Carbon::parse($data['end_date'])->startOfDay();
            }

            // If auto-applied, code should be null
            if ($data['promotion_type'] === 'automatic') {
                $data['code'] = null;
            }

            $promotion->update($data);

            // Clear previous targets
            $promotion->properties()->detach();
            $promotion->propertyTypes()->delete();
            $promotion->destinations()->detach();

            // Re-sync targets
            if ($promotion->target_type === 'properties' && $request->has('property_ids')) {
                $promotion->properties()->sync($request->property_ids);
            } elseif ($promotion->target_type === 'categories' && $request->has('property_types')) {
                $types = array_map(function ($type) {
                    return ['property_type' => $type];
                }, $request->property_types);
                $promotion->propertyTypes()->createMany($types);
            } elseif ($promotion->target_type === 'destinations' && $request->has('destination_ids')) {
                $promotion->destinations()->sync($request->destination_ids);
            }
        });

        return redirect()->route('promotion.index')->with('success', 'Promotion updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion)
    {
        DB::transaction(function () use ($promotion) {
            // Relations have cascadeOnDelete in migrations, but DB::transaction covers model-level soft deleting safely
            $promotion->delete();
        });

        return redirect()->route('promotion.index')->with('success', 'Promotion deleted successfully!');
    }
}
