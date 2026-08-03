@extends('layouts.frontend.main')

@section('title', 'Kelola Akun & Profil - Palma Luxury')

@section('content')
    @php
        $avatarUrl = $user->foto && str_starts_with($user->foto, 'http')
            ? $user->foto
            : ($user->foto && str_starts_with($user->foto, 'avatar-')
                ? asset('assets/img/avatar/' . $user->foto)
                : ($user->foto && Storage::disk('public')->exists('uploads/users/' . $user->foto)
                    ? asset('storage/uploads/users/' . $user->foto)
                    : asset('assets/img/avatar/avatar-1.jpg')));
    @endphp

    <!-- 1. TOP BANNER HEADER -->
    <section class="relative pt-32 pb-24 px-4 sm:px-6 md:px-12 bg-gradient-to-r from-[#152c4e] via-[#1a3862] to-[#152c4e] text-white font-satoshi overflow-hidden">
        <div class="absolute inset-0 opacity-15 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1600&q=80" alt="Villa Sanctuary" class="w-full h-full object-cover">
        </div>
    </section>

    <!-- 2. OVERLAPPING AVATAR & USER PROFILE CONTAINER -->
    <section class="px-4 sm:px-6 md:px-12 max-w-6xl mx-auto font-satoshi -mt-16 relative z-20 pb-16"
             x-data="{ activeTab: '{{ $errors->has('current_password') || $errors->has('new_password') ? 'security' : 'account' }}' }">
        
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-2xl shadow-slate-300/40 space-y-8">
            
            <!-- HEADER TOP ROW: OVERLAPPING AVATAR + NAME + TOP RIGHT UPLOAD PHOTO BUTTON -->
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 pb-6 border-b border-slate-100">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5">
                    <!-- Overlapping Avatar (Clicking triggers Image Cropper Modal) -->
                    <div class="relative -mt-16 sm:-mt-20 shrink-0 cursor-pointer" onclick="document.getElementById('user-profile-cropper-upload').click()">
                        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full p-1 bg-white shadow-2xl border-2 border-slate-100 overflow-hidden">
                            <img src="{{ $avatarUrl }}" id="user-profile-cropper-preview" alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover">
                        </div>
                    </div>

                    <!-- Name & Subtitle -->
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-2xl sm:text-3xl font-serif-title font-bold text-slate-900">{{ $user->name }}</h2>
                            <i class="ri-checkbox-circle-fill text-blue-500 text-xl" title="Terverifikasi"></i>
                        </div>
                        <p class="text-xs text-slate-400 font-medium mt-0.5">{{ $user->email }}</p>
                    </div>
                </div>

                <!-- Top Right "Upload Photo" Button (Replaces My Bookings, triggers Cropper Modal) -->
                <div class="flex items-center gap-3">
                    <label for="user-profile-cropper-upload" class="px-5 py-2.5 rounded-2xl bg-[#152c4e] text-white hover:bg-[#0f1d32] text-xs font-satoshi-bold shadow-sm transition cursor-pointer">
                        Upload Photo
                    </label>
                    <button type="button" 
                            id="user-profile-cropper-reset-btn" 
                            class="px-4 py-2.5 rounded-2xl border border-red-200 bg-red-50 hover:bg-red-100 text-red-700 text-xs font-satoshi-bold transition cursor-pointer"
                            style="display: none;">
                        Reset
                    </button>
                </div>
            </div>

            <!-- METRICS / STATS ROW -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 py-2 border-b border-slate-100">
                <!-- Stat 1 -->
                <div class="pr-4 md:border-r border-slate-200">
                    <span class="block text-xs text-slate-400 font-satoshi-medium">Verifikasi Email</span>
                    <strong class="text-sm font-satoshi-bold text-slate-900 mt-1 block">
                        @if($user->hasVerifiedEmail())
                            <span class="text-emerald-600 flex items-center gap-1"><i class="ri-checkbox-circle-fill"></i> Terverifikasi</span>
                        @else
                            <span class="text-amber-600 flex items-center gap-1"><i class="ri-error-warning-fill"></i> Belum Verifikasi</span>
                        @endif
                    </strong>
                </div>

                <!-- Stat 2 -->
                <div class="pr-4 md:border-r border-slate-200">
                    <span class="block text-xs text-slate-400 font-satoshi-medium">Status Identitas</span>
                    <strong class="text-sm font-satoshi-bold text-slate-900 mt-1 block">
                        @if($user->identity_image && $user->identity_type)
                            <span class="text-emerald-600 uppercase">{{ strtoupper($user->identity_type) }}</span>
                        @else
                            <span class="text-slate-400 italic">Belum Diunggah</span>
                        @endif
                    </strong>
                </div>

                <!-- Stat 3 -->
                <div>
                    <span class="block text-xs text-slate-400 font-satoshi-medium">Bergabung Sejak</span>
                    <strong class="text-sm font-satoshi-bold text-slate-900 mt-1 block">
                        {{ $user->created_at ? $user->created_at->format('d M, Y') : '-' }}
                    </strong>
                </div>
            </div>

            <!-- TABS NAVIGATION BUTTONS -->
            <!-- Enhanced Tabs Navigation with Gradient & Glass Effect -->
            <div class="flex items-center gap-4 bg-white/10 backdrop-blur-lg rounded-2xl p-2">
                <button type="button"
                        @click="activeTab = 'account'"
                        :class="activeTab === 'account' ? 'bg-[#152c4e] text-white' : 'bg-white/30 text-slate-700 hover:bg-white/50 '"
                        class="px-4 py-2 rounded-lg flex shadow-lg items-center gap-2 transition-colors duration-200">
                    <i class="ri-user-3-line"></i>
                    <span>Account Settings</span>
                </button>

                <button type="button"
                        @click="activeTab = 'security'"
                        :class="activeTab === 'security' ? 'bg-[#152c4e] text-white shadow-lg' : 'bg-white/30 text-slate-700 hover:bg-white/50'"
                        class="px-4 py-2 rounded-lg flex items-center gap-2 transition-colors duration-200">
                    <i class="ri-lock-line"></i>
                    <span>Security & Password</span>
                </button>
            </div>

            <!-- ACCOUNT TAB CONTENT -->
            <div x-show="activeTab === 'account'" x-transition:enter="transition ease-out duration-200" class="space-y-8 pt-4">
                <form id="formAccountSettings"
                      method="POST"
                      action="{{ route('user.account.update') }}"
                      enctype="multipart/form-data"
                      class="space-y-8">
                    @csrf

                    <!-- IMAGE CROPPER COMPONENT (Hides default container, keeps modal accessible for top avatar & button) -->
                    <style>#user-profile-cropper-container { display: none !important; }</style>
                    <x-ui.image-cropper 
                        name="foto"
                        id="user-profile-cropper"
                        :value="$avatarUrl"
                        :aspectRatio="1"
                        :width="400"
                        :height="400"
                    />

                    <!-- SECTION 1: PERSONAL INFORMATION -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start pb-8 border-b border-slate-100">
                        <div class="md:col-span-4">
                            <h4 class="text-base font-satoshi-bold text-slate-900">Personal Information</h4>
                            <p class="text-xs text-slate-400 mt-1">Informasi lengkap kontak dan data diri Anda.</p>
                        </div>
                        <div class="md:col-span-8 space-y-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <x-ui.input 
                                    name="name" 
                                    id="name"
                                    :value="old('name', $user->name)" 
                                    label="Full Name" 
                                    placeholder="Full Name" 
                                />

                                <x-ui.input 
                                    type="email"
                                    name="email" 
                                    id="email"
                                    :value="old('email', $user->email)" 
                                    label="E-mail Address" 
                                    placeholder="E-mail Address" 
                                />
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <x-ui.select2 
                                    name="gender" 
                                    label="Gender" 
                                    placeholder="-- Choose --" 
                                    :options="['L' => 'Male', 'P' => 'Female']" 
                                    :value="old('gender', $user->gender)" 
                                />

                                <x-ui.input 
                                    name="phone" 
                                    id="phone"
                                    :value="old('phone', $user->phone)" 
                                    label="Phone Number" 
                                    placeholder="Phone Number" 
                                />
                            </div>

                            <div>
                                <label for="address" class="mb-2 block text-xs font-satoshi-medium text-slate-700">Address</label>
                                <textarea 
                                    id="address" 
                                    name="address" 
                                    rows="3" 
                                    class="block w-full font-satoshi-medium rounded-2xl border px-4 py-3 text-xs outline-none transition focus:bg-white focus:ring-2 {{ $errors->has('address') ? 'border-red-400 bg-red-50/50 text-red-900 focus:border-red-500 focus:ring-red-100' : 'border-slate-200 bg-slate-50 text-slate-900 focus:border-slate-400 focus:ring-slate-200' }}"
                                    placeholder="Address">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <span class="mt-1.5 block text-xs font-medium text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: IDENTITY VERIFICATION -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start pb-8 border-b border-slate-100">
                        <div class="md:col-span-4">
                            <h4 class="text-base font-satoshi-bold text-slate-900">Identity Verification</h4>
                            <p class="text-xs text-slate-400 mt-1">Dokumen resmi (KTP / Passport / SIM) untuk verifikasi reservasi.</p>
                        </div>
                        <div class="md:col-span-8 space-y-5">
                            <x-ui.select2 
                                name="identity_type" 
                                label="Identity Type" 
                                placeholder="-- Choose Identity Type --" 
                                :options="['ktp' => 'KTP', 'paspor' => 'Passport', 'sim' => 'SIM']" 
                                :value="old('identity_type', $user->identity_type)" 
                            />

                            <x-ui.dropzone
                                name="identity_image"
                                label="Identity Document"
                                accept="image/*"
                                :previewUrl="$user->identity_image ? asset('storage/uploads/identities/' . $user->identity_image) : null"
                            />
                        </div>
                    </div>

                    <!-- SUBMIT ACTION -->
                    <div class="flex justify-end pt-2" x-data="{ isSaving: false }">
                        <button type="submit" 
                                @click="isSaving = true" 
                                class="bg-[#152c4e] hover:bg-[#0f1d32] text-white font-bold py-3.5 px-8 rounded-2xl text-xs uppercase tracking-wider transition shadow-md cursor-pointer flex items-center gap-2">
                            <span x-show="!isSaving">Save changes</span>
                            <span x-show="isSaving" style="display: none;" class="flex items-center gap-2">
                                <i class="ri-loader-4-line animate-spin text-sm"></i>
                                <span>Saving...</span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- SECURITY TAB CONTENT -->
            <div x-show="activeTab === 'security'" x-transition:enter="transition ease-out duration-200" class="space-y-8 pt-4" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start pb-8 border-b border-slate-100">
                    <div class="md:col-span-4">
                        <h4 class="text-base font-satoshi-bold text-slate-900">Change Password</h4>
                        <p class="text-xs text-slate-400 mt-1">Pastikan akun Anda menggunakan kata sandi yang kuat dan aman.</p>
                    </div>
                    <div class="md:col-span-8">
                        <form action="{{ route('user.account.update') }}" method="POST" class="space-y-5">
                            @csrf
                            <input type="hidden" name="name" value="{{ $user->name }}">
                            <input type="hidden" name="email" value="{{ $user->email }}">

                            <div>
                                <x-ui.password 
                                    name="current_password" 
                                    label="Current Password" 
                                    placeholder="Enter your current password" 
                                />
                                @error('current_password') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <x-ui.password 
                                        name="new_password" 
                                        label="New Password" 
                                        placeholder="At least 8 characters" 
                                    />
                                    @error('new_password') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <x-ui.password 
                                        name="new_password_confirmation" 
                                        label="Confirm New Password" 
                                        placeholder="Repeat new password" 
                                    />
                                </div>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit" class="bg-[#152c4e] hover:bg-[#0f1d32] text-white font-bold py-3.5 px-8 rounded-2xl text-xs uppercase tracking-wider transition shadow-md cursor-pointer">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
