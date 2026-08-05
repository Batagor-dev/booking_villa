@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Destinations';

    if (isset($destination_data)) {
        $breadcrumbsData = Breadcrumbs::generate(Request::route()->getName(), $destination_data);
    } else {
        $breadcrumbsData = Breadcrumbs::generate(Request::route()->getName());
    }
    $breadcrumb_parent = $breadcrumbsData->where('title', '!=', $breadcrumb->title)->last();
@endphp

@extends('layouts.backend.main')

@section('title', 'Destination Form')
@section('sub_title', $sub_title)

@section('breadcrumb')
    <x-layout.admin.breadcrumb :breadcrumbs="$breadcrumbsData" />
@endsection

@section('content')
    <div class="space-y-6">
        <x-ui.card>
            <form method="POST" action="{{ $action }}" class="space-y-6" enctype="multipart/form-data">
                @isset($destination_data) @method('PUT') @endisset
                @csrf

                <h5 class="text-lg font-satoshi-bold text-slate-900 mb-6">{{ $sub_title }}</h5>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Destination Name -->
                    <x-ui.input 
                        name="name" 
                        label="Destination Name" 
                        placeholder="e.g. Seminyak, Ubud, Uluwatu, Canggu..." 
                        value="{{ old('name', $destination_data->name ?? '') }}"
                        required
                    />

                    <!-- Tags / Features (Tagify Input) -->
                    <x-ui.tagify 
                        name="tags" 
                        label="Categories / Key Tags" 
                        placeholder="Type category & press comma or enter..." 
                        value="{{ old('tags', $destination_data->tags ?? '') }}"
                    />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Sort Order (Unique) -->
                    <x-ui.input 
                        type="number"
                        name="sort" 
                        label="Sort Order" 
                        placeholder="1" 
                        value="{{ old('sort', $destination_data->sort ?? $nextSort ?? '1') }}"
                        required
                        min="1"
                    />

                    <!-- Status / Active -->
                    <div class="flex items-center pt-6">
                        <x-ui.switch 
                            name="status" 
                            label="Active" 
                            value="1"
                            :checked="old('status', $destination_data->status ?? true) ? true : false"
                        />
                    </div>
                </div>

                <!-- Main Attraction / Description -->
                <x-ui.textarea 
                    name="attraction" 
                    label="Main Attraction / Short Description" 
                    placeholder="e.g. Spectacular sunsets & luxury beach lifestyle."
                    value="{{ old('attraction', $destination_data->attraction ?? '') }}"
                    rows="3"
                />

                <!-- Image Upload -->
                <div>
                    <label class="mb-2 block text-base font-satoshi-medium text-slate-700">Destination Image <span class="text-rose-500">*</span></label>
                    <x-ui.dropzone 
                        name="image" 
                        accept="image/*"
                        :previewUrl="isset($destination_data->image_path) ? (str_starts_with($destination_data->image_path, 'http') ? $destination_data->image_path : asset('storage/'.$destination_data->image_path)) : null"
                    />
                </div>

                <!-- Submit / Cancel -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <x-ui.button type="button" font="medium" size="sm" style="secondary" onclick="window.location.href='{{ $breadcrumb_parent?->url ?? route('destination.index') }}'">
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
    {{-- SweetAlert notification --}}
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
