@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Promotions';

    if (isset($promotion_data)) {
        $breadcrumbsData = Breadcrumbs::generate(Request::route()->getName(), $promotion_data);
    } else {
        $breadcrumbsData = Breadcrumbs::generate(Request::route()->getName());
    }
    $breadcrumb_parent = $breadcrumbsData->where('title', '!=', $breadcrumb->title)->last();

    // Map properties for select2 options
    $propertyOptions = $properties->map(fn($p) => ['value' => $p->id, 'label' => $p->name])->toArray();
    
    // Map destinations/regions for select2 options
    $destinationOptions = $destinations->map(fn($d) => ['value' => $d->id, 'label' => $d->name])->toArray();
    
    // Map property types/categories for select2 options
    $typeOptions = array_map(fn($t) => ['value' => $t, 'label' => $t], $propertyTypes);
@endphp

@extends('layouts.backend.main')

@section('title', 'Promotion Form')
@section('sub_title', $sub_title)

@section('breadcrumb')
    <x-layout.admin.breadcrumb :breadcrumbs="$breadcrumbsData" />
@endsection

@section('content')
    <div class="space-y-6 pb-12">
        <x-ui.card>
            <form method="POST" action="{{ $action }}" class="space-y-6" enctype="multipart/form-data"
                  x-data="{ 
                      promotionType: '{{ old('promotion_type', $promotion_data->promotion_type ?? 'automatic') }}',
                      targetType: '{{ old('target_type', $promotion_data->target_type ?? 'all') }}',
                      discountType: '{{ old('discount_type', $promotion_data->discount_type ?? 'percentage') }}'
                  }"
                  @change="
                      if ($event.target.name === 'promotion_type') promotionType = $event.target.value;
                      if ($event.target.name === 'target_type') targetType = $event.target.value;
                      if ($event.target.name === 'discount_type') discountType = $event.target.value;
                  ">
                @isset($promotion_data) @method('PUT') @endisset
                @csrf

                <h5 class="text-lg font-satoshi-bold text-slate-900 mb-6">{{ $sub_title }}</h5>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Promotion Name -->
                    <x-ui.input 
                        name="name" 
                        label="Promotion Name *" 
                        placeholder="e.g. Welcome 10% Discount" 
                        value="{{ old('name', $promotion_data->name ?? '') }}"
                        required
                    />

                    <!-- Status / Active -->
                    <div class="flex items-center pt-8">
                        <x-ui.switch 
                            name="status" 
                            label="Active" 
                            value="1"
                            :checked="old('status', $promotion_data->status ?? true) ? true : false"
                        />
                    </div>
                </div>

                <!-- Description -->
                <x-ui.textarea 
                    name="description" 
                    label="Description" 
                    placeholder="Describe the promotion benefits..."
                    value="{{ old('description', $promotion_data->description ?? '') }}"
                    rows="3"
                />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Promotion Type -->
                    <x-ui.select2 
                        name="promotion_type" 
                        label="Promotion Type *" 
                        placeholder="Select type..."
                        :multiple="false"
                        :options="[
                            ['value' => 'automatic', 'label' => 'Automatic (Applied without code)'],
                            ['value' => 'code', 'label' => 'Voucher / Promo Code']
                        ]"
                        value="{{ old('promotion_type', $promotion_data->promotion_type ?? 'automatic') }}"
                    />

                    <!-- Promo Code (Only visible if type is Code) -->
                    <div x-show="promotionType === 'code'" x-transition class="w-full">
                        <x-ui.input 
                            name="code" 
                            label="Voucher Code *" 
                            placeholder="e.g. WELCOME100" 
                            value="{{ old('code', $promotion_data->code ?? '') }}"
                        />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Discount Type -->
                    <x-ui.select2 
                        name="discount_type" 
                        label="Discount Type *" 
                        placeholder="Select discount type..."
                        :multiple="false"
                        :options="[
                            ['value' => 'percentage', 'label' => 'Percentage (%)'],
                            ['value' => 'fixed', 'label' => 'Fixed Amount (Rp)']
                        ]"
                        value="{{ old('discount_type', $promotion_data->discount_type ?? 'percentage') }}"
                    />

                    <!-- Discount Value -->
                    <div class="w-full">
                        <div x-show="discountType === 'percentage'" x-transition>
                            <x-ui.input 
                                type="number"
                                name="discount_value_percentage" 
                                label="Discount Percentage (%) *" 
                                placeholder="e.g. 10 for 10%" 
                                value="{{ old('discount_value_percentage', $discount_value_percentage ?? '') }}"
                                min="0"
                                max="100"
                            />
                        </div>
                        <div x-show="discountType === 'fixed'" x-transition>
                            <x-ui.price 
                                type="input"
                                name="discount_value_fixed" 
                                label="Discount Amount (IDR) *" 
                                placeholder="e.g. 50.000" 
                                value="{{ old('discount_value_fixed', $discount_value_fixed ?? '') }}"
                            />
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Min Nights -->
                    <x-ui.input 
                        type="number"
                        name="min_nights" 
                        label="Minimum Nights Stay" 
                        placeholder="e.g. 3 (leave blank for no limit)" 
                        value="{{ old('min_nights', $promotion_data->min_nights ?? '') }}"
                        min="0"
                    />

                    <!-- Min Transaction Subtotal -->
                    <x-ui.price 
                        type="input"
                        name="min_transaction" 
                        label="Minimum Transaction Amount (IDR)" 
                        placeholder="e.g. 1.000.000 (leave blank for no limit)" 
                        value="{{ old('min_transaction', $promotion_data->min_transaction ?? '') }}"
                    />
                </div>

                <!-- Target Configuration -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-ui.select2 
                        name="target_type" 
                        label="Target Applicability *" 
                        placeholder="Select target level..."
                        :multiple="false"
                        :options="[
                            ['value' => 'all', 'label' => 'All Properties'],
                            ['value' => 'properties', 'label' => 'Specific Properties'],
                            ['value' => 'categories', 'label' => 'Property Categories / Types'],
                            ['value' => 'destinations', 'label' => 'Wilayah / Regions']
                        ]"
                        value="{{ old('target_type', $promotion_data->target_type ?? 'all') }}"
                    />

                    <!-- Target Properties Dropdown (Visible if properties) -->
                    <div x-show="targetType === 'properties'" x-transition class="w-full">
                        <x-ui.select2 
                            name="property_ids" 
                            label="Select Properties *" 
                            placeholder="Search & choose properties..."
                            :multiple="true"
                            :options="$propertyOptions"
                            :value="old('property_ids', $selectedProperties ?? [])"
                        />
                    </div>

                    <!-- Target Categories Dropdown (Visible if categories) -->
                    <div x-show="targetType === 'categories'" x-transition class="w-full">
                        <x-ui.select2 
                            name="property_types" 
                            label="Select Property Types *" 
                            placeholder="Search & choose types..."
                            :multiple="true"
                            :options="$typeOptions"
                            :value="old('property_types', $selectedPropertyTypes ?? [])"
                        />
                    </div>

                    <!-- Target Destinations Dropdown (Visible if destinations) -->
                    <div x-show="targetType === 'destinations'" x-transition class="w-full">
                        <x-ui.select2 
                            name="destination_ids" 
                            label="Select Destinations *" 
                            placeholder="Search & choose destinations..."
                            :multiple="true"
                            :options="$destinationOptions"
                            :value="old('destination_ids', $selectedDestinations ?? [])"
                        />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Start Date -->
                    <div class="w-full">
                        <label for="start_date" class="mb-2 block text-base font-satoshi-medium text-slate-700">
                            Start Date *
                        </label>
                        <x-ui.date 
                            id="start_date"
                            name="start_date" 
                            placeholder="Select start date"
                            value="{{ old('start_date', isset($promotion_data) ? $promotion_data->start_date->format('Y-m-d') : '') }}"
                            required
                        />
                    </div>

                    <!-- End Date -->
                    <div class="w-full">
                        <label for="end_date" class="mb-2 block text-base font-satoshi-medium text-slate-700">
                            End Date *
                        </label>
                        <x-ui.date 
                            id="end_date"
                            name="end_date" 
                            placeholder="Select end date"
                            value="{{ old('end_date', isset($promotion_data) ? $promotion_data->end_date->format('Y-m-d') : '') }}"
                            required
                        />
                    </div>
                </div>

                <!-- Submit / Cancel -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <x-ui.button type="button" font="medium" size="sm" style="secondary" onclick="window.location.href='{{ $breadcrumb_parent?->url ?? route('promotion.index') }}'">
                        Cancel
                    </x-ui.button>
                    <x-ui.button type="submit" font="bold" size="sm">
                        Submit
                    </x-ui.button>
                </div>
            </form>
        </x-ui.card>
    </div>
@endsection
