@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Reviews & Ulasan Tamu';
    $breadcrumbsData = Breadcrumbs::generate(Request::route()->getName());
@endphp

@extends('layouts.backend.main')

@section('title', 'Reviews & Ulasan')
@section('sub_title', $sub_title)

@section('breadcrumb')
    <x-layout.admin.breadcrumb :breadcrumbs="$breadcrumbsData" />
@endsection

@section('content')
<div class="space-y-8 pb-12 font-satoshi">
    <x-ui.card>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-100">
            <div>
                <h5 class="text-xl font-satoshi-bold text-slate-900 mb-0">Daftar Ulasan Tamu Villa</h5>
            </div>
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
