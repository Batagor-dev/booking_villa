@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Articles';
    $breadcrumbsData = Breadcrumbs::generate(Request::route()->getName());
@endphp

@extends('layouts.backend.main')

@section('title', 'Articles')
@section('sub_title', $sub_title)

@section('breadcrumb')
    <x-layout.admin.breadcrumb :breadcrumbs="$breadcrumbsData" />
@endsection

@section('content')
<div class="space-y-8 pb-12">
    <x-ui.card>
        <div class="flex items-center justify-between mb-4">
            <h5 class="text-lg font-satoshi-bold text-slate-900 mb-0">{{ $sub_title }}</h5>
            @can('Article Create')
                <x-ui.button href="{{ route('article.create') }}" color="primary" size="sm">
                    <i class="ri-add-line mr-1"></i> Add Article
                </x-ui.button>
            @endcan
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
