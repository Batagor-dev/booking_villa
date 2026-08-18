@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Facilities';

    if (isset($facility_data)) {
        $breadcrumbsData = Breadcrumbs::generate(Request::route()->getName(), $facility_data);
    } else {
        $breadcrumbsData = Breadcrumbs::generate(Request::route()->getName());
    }
    $breadcrumb_parent = $breadcrumbsData->where('title', '!=', $breadcrumb->title)->last();
@endphp

@extends('layouts.backend.main')

@section('title', 'Facility Form')
@section('sub_title', $sub_title)

@section('breadcrumb')
    <x-layout.admin.breadcrumb :breadcrumbs="$breadcrumbsData" />
@endsection

@section('content')
    <div class="space-y-6">
        <x-ui.card>
            <form method="POST" action="{{ $action }}" class="space-y-6" enctype="multipart/form-data">
                @isset($facility_data) @method('PUT') @endisset
                @csrf

                <h5 class="text-lg font-satoshi-bold text-slate-900 mb-6">{{ $sub_title }}</h5>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Facility Name -->
                    <x-ui.input 
                        name="name" 
                        label="Facility Name" 
                        placeholder="e.g. Swimming Pool, Free Wi-Fi, Air Conditioning" 
                        value="{{ old('name', $facility_data->name ?? '') }}"
                        required
                    />

@php
    $categories = [
        ['value' => 'General', 'label' => 'General'],
        ['value' => 'Outdoor', 'label' => 'Outdoor'],
        ['value' => 'Room', 'label' => 'Room'],
        ['value' => 'Bathroom', 'label' => 'Bathroom'],
        ['value' => 'Entertainment', 'label' => 'Entertainment'],
        ['value' => 'Wellness', 'label' => 'Wellness'],
        ['value' => 'Safety & Security', 'label' => 'Safety & Security'],
    ];
@endphp

                    <!-- Category -->
                    <div>
                        <x-ui.select2 
                            name="category" 
                            label="Category" 
                            placeholder="Select Category..." 
                            :options="$categories"
                            :value="old('category', $facility_data->category ?? '')"
                        />
                    </div>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Remix Icon Class -->
                    <x-ui.input 
                        name="icon" 
                        label="Remix Icon Class (Optional)" 
                        placeholder="e.g. ri-wifi-line, ri-drop-line, ri-tv-2-line" 
                        value="{{ old('icon', $facility_data->icon ?? '') }}"
                    />

                    <!-- Sort Order -->
                    <x-ui.input 
                        type="number"
                        name="sort" 
                        label="Sort Order" 
                        placeholder="1" 
                        value="{{ old('sort', $facility_data->sort ?? '1') }}"
                        required
                        min="1"
                    />

                    <!-- Status / Active -->
                    <div class="flex items-center pt-6">
                        <x-ui.switch 
                            name="status" 
                            label="Active" 
                            value="1"
                            :checked="old('status', $facility_data->status ?? true) ? true : false"
                        />
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <x-ui.textarea 
                        name="description" 
                        label="Description" 
                        placeholder="Deskripsi dan detail fasilitas..."
                        value="{{ old('description', $facility_data->description ?? '') }}"
                        rows="3"
                    />
                    <div class="mt-2 flex items-center gap-1.5 text-xs text-slate-400">
                        <i class="ri-sparkling-fill text-amber-500 text-sm"></i>
                        <span>Input dalam Bahasa Indonesia. Terjemahan bahasa Inggris otomatis diproses oleh Gemini AI saat disimpan.</span>
                    </div>
                </div>

                <!-- Facility Image -->
                <div>
                    <label class="mb-2 block text-base font-satoshi-medium text-slate-700">Facility Image (Optional)</label>
                    <x-ui.dropzone 
                        name="image" 
                        accept="image/*"
                        :previewUrl="isset($facility_data->image_path) ? asset('storage/'.$facility_data->image_path) : null"
                    />
                </div>

                <!-- Submit / Cancel -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <x-ui.button type="button" font="medium" size="sm" style="secondary" onclick="window.location.href='{{ $breadcrumb_parent?->url ?? route('facilities.index') }}'">
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
