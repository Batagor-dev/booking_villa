@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Peraturan Villa';

    if (isset($rule_data)) {
        $breadcrumbsData = Breadcrumbs::generate(Request::route()->getName(), $rule_data);
    } else {
        $breadcrumbsData = Breadcrumbs::generate(Request::route()->getName());
    }
    $breadcrumb_parent = $breadcrumbsData->where('title', '!=', $breadcrumb->title)->last();

    $propertyTypes = [
        ['value' => 'all', 'label' => 'Semua Tipe Properti'],
        ['value' => 'Villa', 'label' => 'Villa'],
        ['value' => 'Resort', 'label' => 'Resort'],
        ['value' => 'Boutique Hotel', 'label' => 'Boutique Hotel'],
        ['value' => 'Apartment', 'label' => 'Apartment'],
        ['value' => 'Private House', 'label' => 'Private House'],
    ];
@endphp

@extends('layouts.backend.main')

@section('title', $sub_title)
@section('sub_title', $sub_title)

@section('breadcrumb')
    <x-layout.admin.breadcrumb :breadcrumbs="$breadcrumbsData" />
@endsection

@section('content')
    <div class="space-y-6">
        <x-ui.card>
            <form method="POST" action="{{ $action }}" class="space-y-6">
                @isset($rule_data) @method('PUT') @endisset
                @csrf

                <h5 class="text-lg font-satoshi-bold text-slate-900 mb-6">{{ $sub_title }}</h5>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Judul Peraturan -->
                    <x-ui.input 
                        name="title" 
                        label="Judul Peraturan" 
                        placeholder="Contoh: Waktu Check-in & Check-out, Jam Tenang, dll" 
                        value="{{ old('title', $rule_data->title ?? '') }}"
                        required
                    />

                    <!-- Tipe Properti Target -->
                    <div>
                        <x-ui.select2 
                            name="property_type" 
                            label="Tipe Properti Target" 
                            placeholder="Pilih Tipe Properti..." 
                            :options="$propertyTypes"
                            :value="old('property_type', $rule_data->property_type ?? 'all')"
                        />
                    </div>
                </div>

                <!-- Deskripsi Peraturan -->
                <div>
                    <x-ui.textarea 
                        name="description" 
                        label="Deskripsi & Detail Ketentuan" 
                        placeholder="Tuliskan detail ketentuan peraturan ini secara rinci..."
                        value="{{ old('description', $rule_data->description ?? '') }}"
                        rows="3"
                        required
                    />
                    <div class="mt-2 flex items-center gap-1.5 text-xs text-slate-400">
                        <i class="ri-sparkling-fill text-amber-500 text-sm"></i>
                        <span>Input dalam Bahasa Indonesia. Terjemahan judul & deskripsi ke bahasa Inggris otomatis diproses oleh Gemini AI saat disimpan.</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Remix Icon Class -->
                    <x-ui.input 
                        name="icon" 
                        label="Ikon Remix Icon (Opsional)" 
                        placeholder="Contoh: ri-time-line, ri-team-line, ri-forbid-2-line" 
                        value="{{ old('icon', $rule_data->icon ?? '') }}"
                    />

                    <!-- Sort Order -->
                    <x-ui.input 
                        type="number"
                        name="sort_order" 
                        label="Urutan Tampilan (Sort Order)" 
                        placeholder="1" 
                        value="{{ old('sort_order', $rule_data->sort_order ?? 1) }}"
                        required
                        min="0"
                    />

                    <!-- Status / Active -->
                    <div class="flex items-center pt-6">
                        <x-ui.switch 
                            name="is_active" 
                            label="Status Aktif" 
                            value="1"
                            :checked="old('is_active', $rule_data->is_active ?? true) ? true : false"
                        />
                    </div>
                </div>

                <!-- Submit / Cancel Action Buttons -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <x-ui.button type="button" font="medium" size="sm" style="secondary" onclick="window.location.href='{{ $breadcrumb_parent?->url ?? route('property_rules.index') }}'">
                        Cancel
                    </x-ui.button>
                    <x-ui.button type="submit" font="medium" size="sm">
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
