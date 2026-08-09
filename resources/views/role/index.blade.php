@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';
    $breadcrumbsData = Breadcrumbs::generate(Request::route()->getName());
@endphp

@extends('layouts.backend.main')

@section('title', 'User Roles')
@section('sub_title', $sub_title)

@section('breadcrumb')
    <x-layout.admin.breadcrumb :breadcrumbs="$breadcrumbsData" />
@endsection

@section('content')
<div class="space-y-8 pb-12">
    <x-ui.card>
        <div class="flex items-center justify-between mb-4">
            <h5 class="mb-0">{{$sub_title}}</h5>
            <x-ui.button href="{{ route('role.create') }}" color="primary" size="sm">
                <i class="ri-add-line mr-1"></i> Add Role
            </x-ui.button>
        </div>
        <div>
            {{ $dataTable->table(['width' => '100%']) }}
        </div>
    </x-ui.card>    
</div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush