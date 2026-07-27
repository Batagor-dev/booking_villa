@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Banners';

    if (isset($banner_data)) {
        $breadcrumbsData = Breadcrumbs::generate(Request::route()->getName(), $banner_data);
    } else {
        $breadcrumbsData = Breadcrumbs::generate(Request::route()->getName());
    }
    $breadcrumb_parent = $breadcrumbsData->where('title', '!=', $breadcrumb->title)->last();
@endphp

@extends('layouts.backend.main')

@section('title', 'Banner Form')
@section('sub_title', $sub_title)

@section('breadcrumb')
    <x-layout.admin.breadcrumb :breadcrumbs="$breadcrumbsData" />
@endsection

@section('content')
    <div class="space-y-6">
        <x-ui.card>
            <form method="POST" action="{{ $action }}" class="space-y-6" enctype="multipart/form-data">
                @isset($banner_data) @method('PUT') @endisset
                @csrf

                <h5 class="text-lg font-satoshi-bold text-slate-900 mb-6">{{ $sub_title }}</h5>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <x-ui.input 
                        name="title" 
                        label="Title" 
                        placeholder="Banner Title" 
                        value="{{ old('title', $banner_data->title ?? '') }}"
                        required
                    />

                    <!-- Subtitle -->
                    <x-ui.input 
                        name="subtitle" 
                        label="Subtitle" 
                        placeholder="Banner Subtitle" 
                        value="{{ old('subtitle', $banner_data->subtitle ?? '') }}"
                    />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Link URL -->
                    <x-ui.input 
                        name="link_url" 
                        label="Link URL" 
                        placeholder="e.g. /promo/winter or https://example.com" 
                        value="{{ old('link_url', $banner_data->link_url ?? '') }}"
                    />

                    <!-- Sort Order -->
                    <x-ui.input 
                        type="number"
                        name="sort" 
                        label="Sort Order" 
                        placeholder="1" 
                        value="{{ old('sort', $banner_data->sort ?? '1') }}"
                        required
                        min="1"
                    />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Banner Image -->
                    <div>
                        <label class="mb-2 block text-base font-satoshi-medium text-slate-700">Banner Image</label>
                        <x-ui.dropzone 
                            name="image" 
                            accept="image/*"
                            :previewUrl="isset($banner_data->image_path) ? asset('storage/'.$banner_data->image_path) : null"
                            :required="!isset($banner_data)"
                        />
                        <p class="text-xs text-slate-500 mt-2 font-satoshi-medium">Disarankan ukuran foto 16:9</p>
                    </div>
                    <!-- Status / Active -->
                    <div>
                        <x-ui.switch 
                            name="status" 
                            label="Active" 
                            value="1"
                            :checked="old('status', $banner_data->status ?? true) ? true : false"
                        />
                    </div>
                </div>

                <!-- Submit / Cancel -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <x-ui.button type="button" font="medium" size="sm" style="secondary" onclick="window.location.href='{{ $breadcrumb_parent?->url ?? route('banner.index') }}'">
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
            Swal.fire({ icon: 'error',   title: 'Error',  text: "{{ session('error') }}" });
        </script>
    @endif
@endpush
