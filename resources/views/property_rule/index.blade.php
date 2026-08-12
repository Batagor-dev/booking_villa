@php
    $sub_title = 'Master Peraturan Villa (Rules)';
    $breadcrumbsData = collect([
        (object)['title' => 'Dashboard', 'url' => route('dashboard')],
        (object)['title' => 'Peraturan Villa', 'url' => '']
    ]);
@endphp

@extends('layouts.backend.main')

@section('title', 'Peraturan Villa (Global Rules)')
@section('sub_title', $sub_title)

@section('breadcrumb')
    <x-layout.admin.breadcrumb :breadcrumbs="$breadcrumbsData" />
@endsection

@section('content')
<div class="space-y-8 pb-12">
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="ri-checkbox-circle-fill text-emerald-600 text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                <i class="ri-close-line"></i>
            </button>
        </div>
    @endif

    <x-ui.card>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h5 class="text-lg font-satoshi-bold text-slate-900 mb-1">Peraturan & Ketentuan Pemesanan Villa</h5>
                <p class="text-xs text-slate-500">Kelola daftar peraturan & ketentuan pemesanan yang berlaku untuk tipe properti tertentu maupun seluruh properti.</p>
            </div>
            <x-ui.button href="{{ route('property_rules.create') }}" color="primary" size="sm" class="shrink-0">
                <i class="ri-add-line mr-1"></i> Tambah Peraturan
            </x-ui.button>
        </div>

        <div>
            {!! $dataTable->table(['width' => '100%']) !!}
        </div>
    </x-ui.card>
</div>
@endsection

@push('scripts')
    {{-- Render DataTable --}}
    {!! $dataTable->scripts() !!}
@endpush
