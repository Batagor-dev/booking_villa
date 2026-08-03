@php
    $breadcrumbsData = Breadcrumbs::generate(); 
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Dashboard';
@endphp

@extends('layouts.backend.main')

@section('title', 'User Settings')
@section('sub_title', $sub_title)

@section('breadcrumb')
    <x-layout.admin.breadcrumb :breadcrumbs="$breadcrumbsData" />
@endsection

@section('content')
<div class="space-y-6 pb-12">
    <!-- Tabs Nav -->
    <div class="flex items-center gap-2 bg-slate-100 p-1.5 rounded-2xl w-fit">
        <a href="javascript:void(0);" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white text-slate-900 font-satoshi-bold shadow-sm transition">
            <i class="ri-user-3-line text-lg"></i>
            <span>Account</span>
        </a>
        <a href="{{ route('acount.security') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-slate-500 hover:text-slate-900 font-satoshi-medium transition">
            <i class="ri-lock-line text-lg"></i>
            <span>Security</span>
        </a>
    </div>

    <form id="formAccountSettings"
          method="POST"
          action="{{ route('acount.store') }}"
          enctype="multipart/form-data"
          class="space-y-6">
        @csrf

        <!-- Personal Profile Card -->
        <x-ui.card>
            <h5 class="text-lg font-satoshi-bold text-slate-900 mb-6">Personal Profile</h5>

            {{-- Reusable Image Cropper Component with 1:1 ratio and Reset --}}
            <x-ui.image-cropper 
                name="foto"
                :value="Auth::user()->foto && str_starts_with(Auth::user()->foto, 'http')
                        ? Auth::user()->foto
                        : (Auth::user()->foto && str_starts_with(Auth::user()->foto, 'avatar-')
                            ? asset('assets/img/avatar/' . Auth::user()->foto)
                            : asset('storage/uploads/users/' . Auth::user()->foto))"
                :aspectRatio="1"
                :width="400"
                :height="400"
            />

            {{-- Fields Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <x-ui.input 
                        name="name" 
                        id="name"
                        :value="old('name', Auth::user()->name)" 
                        label="Full Name" 
                        placeholder="Full Name" 
                    />
                </div>

                <div>
                    <x-ui.input 
                        type="email"
                        name="email" 
                        id="email"
                        :value="old('email', Auth::user()->email)" 
                        label="E-mail" 
                        placeholder="E-mail" 
                    />
                </div>

                <div>
                    <x-ui.select2 
                        name="gender" 
                        label="Gender" 
                        placeholder="-- Choose --" 
                        :options="['L' => 'Male', 'P' => 'Female']" 
                        :value="old('gender', Auth::user()->gender)" 
                    />
                </div>

                <div>
                    <x-ui.input 
                        name="phone" 
                        id="phone"
                        :value="old('phone', Auth::user()->phone)" 
                        label="Phone Number" 
                        placeholder="Phone Number" 
                    />
                </div>

                <div class="md:col-span-2">
                    <div class="w-full">
                        <label for="address" class="mb-2 block text-base font-satoshi-medium text-slate-700">Address</label>
                        <textarea 
                            id="address" 
                            name="address" 
                            rows="3" 
                            class="block w-full font-satoshi-medium rounded-2xl border px-4 py-3 text-base outline-none transition focus:bg-white focus:ring-2 {{ $errors->has('address') ? 'border-red-400 bg-red-50/50 text-red-900 focus:border-red-500 focus:ring-red-100' : 'border-slate-200 bg-slate-50 text-slate-900 focus:border-slate-400 focus:ring-slate-200' }}"
                            placeholder="Address">{{ old('address', Auth::user()->address) }}</textarea>
                        @error('address')
                            <span class="mt-1.5 block text-sm font-medium text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </x-ui.card>

        <!-- Identity Verification Card -->
        <x-ui.card>
            <h5 class="text-lg font-satoshi-bold text-slate-900 mb-6">Identity Verification</h5>

            <div class="space-y-6">
                <x-ui.select2 
                    name="identity_type" 
                    label="Identity Type" 
                    placeholder="-- Choose Identity Type --" 
                    :options="['ktp' => 'KTP', 'paspor' => 'Passport', 'sim' => 'SIM']" 
                    :value="old('identity_type', Auth::user()->identity_type)" 
                />

                <x-ui.dropzone
                    name="identity_image"
                    label="Identity Document"
                    accept="image/*"
                    :previewUrl="Auth::user()->identity_image ? asset('storage/uploads/identities/' . Auth::user()->identity_image) : null"
                />
            </div>
        </x-ui.card>

        {{-- Submit --}}
        <div class="flex justify-end">
            <x-ui.button type="submit" size="md">
                Save changes
            </x-ui.button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
@if(session('success'))
<script>Swal.fire({icon:'success',title:'Success',text:"{{ session('success') }}"});</script>
@endif
@if(session('error'))
<script>Swal.fire({icon:'error',title:'Error',text:"{{ session('error') }}"});</script>
@endif
@endpush