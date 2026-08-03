@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Property Services';

    if (isset($service_data)) {
        $breadcrumbsData = Breadcrumbs::generate(Request::route()->getName(), $service_data);
    } else {
        $breadcrumbsData = Breadcrumbs::generate(Request::route()->getName());
    }
    $breadcrumb_parent = $breadcrumbsData->where('title', '!=', $breadcrumb->title)->last();
@endphp

@extends('layouts.backend.main')

@section('title', 'Property Service Form')
@section('sub_title', $sub_title)

@section('breadcrumb')
    <x-layout.admin.breadcrumb :breadcrumbs="$breadcrumbsData" />
@endsection

@section('content')
    <div class="space-y-6">
        <x-ui.card>
            <form method="POST" action="{{ $action }}" class="space-y-6" enctype="multipart/form-data">
                @isset($service_data) @method('PUT') @endisset
                @csrf

                <h5 class="text-lg font-satoshi-bold text-slate-900 mb-6">{{ $sub_title }}</h5>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Service Name -->
                    <x-ui.input 
                        name="name" 
                        label="Service Name" 
                        placeholder="e.g. Airport Transfer, Spa Massage, Breakfast" 
                        value="{{ old('name', $service_data->name ?? '') }}"
                        required
                    />

                    @php
                        $serviceCategories = [
                            ['value' => 'Transport', 'label' => 'Transport'],
                            ['value' => 'F&B', 'label' => 'F&B (Food & Beverage)'],
                            ['value' => 'Wellness', 'label' => 'Wellness & Spa'],
                            ['value' => 'Tour', 'label' => 'Tour & Activity'],
                            ['value' => 'Laundry', 'label' => 'Laundry & Cleaning'],
                            ['value' => 'Entertainment', 'label' => 'Entertainment'],
                        ];
                    @endphp

                    <!-- Category -->
                    <div>
                        <x-ui.select2 
                            name="category" 
                            label="Category" 
                            placeholder="Select Category..." 
                            :options="$serviceCategories"
                            :value="old('category', $service_data->category ?? '')"
                        />
                    </div>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Price -->
                    <x-ui.input 
                        type="number"
                        name="price" 
                        label="Price (Rp)" 
                        placeholder="0" 
                        value="{{ old('price', $service_data->price ?? '0') }}"
                        required
                        min="0"
                        step="5000"
                    />

                    @php
                        $priceTypes = [
                            ['value' => 'per_item', 'label' => 'Per Item'],
                            ['value' => 'per_person', 'label' => 'Per Person'],
                            ['value' => 'per_stay', 'label' => 'Per Stay'],
                            ['value' => 'per_hour', 'label' => 'Per Hour'],
                            ['value' => 'fixed', 'label' => 'Fixed'],
                        ];
                    @endphp

                    <!-- Price Type -->
                    <div>
                        <x-ui.select2 
                            name="price_type" 
                            label="Price Type *" 
                            placeholder="Select Price Type..." 
                            :options="$priceTypes"
                            :value="old('price_type', $service_data->price_type ?? 'per_item')"
                        />
                    </div>


                    <!-- Sort Order -->
                    <x-ui.input 
                        type="number"
                        name="sort" 
                        label="Sort Order" 
                        placeholder="1" 
                        value="{{ old('sort', $service_data->sort ?? '1') }}"
                        required
                        min="1"
                    />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Remix Icon Class -->
                    <x-ui.input 
                        name="icon" 
                        label="Remix Icon Class (Optional)" 
                        placeholder="e.g. ri-car-line, ri-restaurant-line, ri-spa-line" 
                        value="{{ old('icon', $service_data->icon ?? '') }}"
                    />

                    <!-- Status / Active -->
                    <div class="flex items-center pt-6">
                        <x-ui.switch 
                            name="status" 
                            label="Active" 
                            value="1"
                            :checked="old('status', $service_data->status ?? true) ? true : false"
                        />
                    </div>
                </div>

                <!-- Description -->
                <x-ui.textarea 
                    name="description" 
                    label="Description" 
                    placeholder="Service description details..."
                    value="{{ old('description', $service_data->description ?? '') }}"
                    rows="3"
                />

                <!-- Service Image -->
                <div>
                    <label class="mb-2 block text-base font-satoshi-medium text-slate-700">Service Image (Optional)</label>
                    <x-ui.dropzone 
                        name="image" 
                        accept="image/*"
                        :previewUrl="isset($service_data->image_path) ? asset('storage/'.$service_data->image_path) : null"
                    />
                </div>

                <!-- Submit / Cancel -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <x-ui.button type="button" font="medium" size="sm" style="secondary" onclick="window.location.href='{{ $breadcrumb_parent?->url ?? route('property_services.index') }}'">
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

@push('scripts')
    {{-- SweetAlert otomatis --}}
    @if(session('success'))
        <script>
            Swal.fire({ icon: 'success', title: 'Success', text: "{{ session('success') }}" });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({ icon: 'error', title: 'Error', text: "{{ session('error') }}" });
        </script>
    @endif
@endpush
