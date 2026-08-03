@extends('layouts.frontend.main')

@section('title', 'Kelola Akun & Profil - Palma Luxury')

@section('content')
    <!-- HERO HEADER -->
    <section class="relative pt-32 pb-12 px-4 sm:px-6 md:px-12 bg-[#152c4e] text-white font-satoshi overflow-hidden">
        <div class="absolute inset-0 opacity-15 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1600&q=80" alt="Villa Sanctuary" class="w-full h-full object-cover">
        </div>
        <div class="max-w-7xl mx-auto relative z-10">
            <!-- Breadcrumbs -->
            <div class="flex items-center gap-2 text-xs text-white/70 mb-3 font-medium">
                <a href="{{ route('home') }}" class="hover:text-[#ca9e54] transition-colors">Beranda</a>
                <span>/</span>
                <a href="{{ route('user.bookings') }}" class="hover:text-[#ca9e54] transition-colors">My Bookings</a>
                <span>/</span>
                <span class="text-white font-semibold">Kelola Akun</span>
            </div>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <span class="text-[10px] sm:text-xs font-bold tracking-[0.25em] text-[#e5c382] uppercase block mb-1">Pengaturan Profil Pengguna</span>
                    <h1 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-normal text-white">
                        Kelola Informasi Akun
                    </h1>
                </div>
                <a href="{{ route('user.bookings') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/10 hover:bg-white/20 text-white text-xs font-bold transition border border-white/20 shrink-0 w-fit">
                    <i class="ri-history-line text-sm"></i> Lihat Riwayat Booking
                </a>
            </div>
        </div>
    </section>

    <!-- MAIN CONTAINER -->
    <section class="py-10 sm:py-14 px-4 sm:px-6 md:px-12 max-w-7xl mx-auto font-satoshi">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- LEFT COLUMN: USER PROFILE OVERVIEW (4 Cols) -->
            <div class="lg:col-span-4 bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-sm space-y-6 text-center">
                
                <div class="relative inline-block mx-auto">
                    <div class="w-24 h-24 rounded-full bg-[#152c4e] text-[#e5c382] flex items-center justify-center font-serif-title text-3xl font-bold shadow-lg mx-auto border-4 border-white">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                </div>

                <div>
                    <h3 class="font-serif-title text-xl font-bold text-slate-900">{{ $user->name }}</h3>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">{{ $user->email }}</p>
                    <span class="inline-block mt-2 px-3 py-1 bg-amber-50 text-amber-800 text-[10px] font-bold uppercase rounded-full border border-amber-200">
                        {{ $user->roles->first()->name ?? 'Pelanggan VVIP' }}
                    </span>
                </div>

                <div class="pt-4 border-t border-slate-100 space-y-3 text-xs text-left">
                    <div class="flex items-center justify-between text-slate-600">
                        <span>Status Verifikasi Email:</span>
                        @if($user->hasVerifiedEmail())
                            <span class="text-emerald-600 font-bold flex items-center gap-1"><i class="ri-checkbox-circle-fill"></i> Terverifikasi</span>
                        @else
                            <span class="text-amber-600 font-bold flex items-center gap-1"><i class="ri-error-warning-fill"></i> Belum Verifikasi</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between text-slate-600">
                        <span>Bergabung Sejak:</span>
                        <strong class="text-slate-900">{{ $user->created_at->format('M Y') }}</strong>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 space-y-2">
                    <a href="{{ route('user.bookings') }}" class="block w-full py-2.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold transition">
                        <i class="ri-calendar-event-line mr-1"></i> My Bookings
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold transition cursor-pointer">
                            <i class="ri-logout-box-r-line mr-1"></i> Keluar Dari Akun
                        </button>
                    </form>
                </div>

            </div>

            <!-- RIGHT COLUMN: EDIT PROFILE & SECURITY FORMS (8 Cols) -->
            <div class="lg:col-span-8 space-y-8">
                
                <!-- PROFILE INFORMATION FORM -->
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-sm space-y-6">
                    
                    <div class="border-b border-slate-100 pb-4">
                        <h2 class="font-serif-title text-xl font-bold text-slate-900">Informasi Data Diri</h2>
                        <p class="text-xs text-slate-500 mt-1">Perbarui informasi kontak dan alamat lengkap Anda.</p>
                    </div>

                    <form action="{{ route('user.account.update') }}" method="POST" class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <x-ui.input 
                                name="name" 
                                label="Nama Lengkap" 
                                value="{{ old('name', $user->name) }}"
                                required
                            />

                            <x-ui.input 
                                type="email"
                                name="email" 
                                label="Alamat Email" 
                                value="{{ old('email', $user->email) }}"
                                required
                            />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <x-ui.input 
                                name="phone" 
                                label="Nomor Telepon / WhatsApp" 
                                placeholder="+62 812 3456 7890"
                                value="{{ old('phone', $user->phone) }}"
                            />

                            <div>
                                <label class="block text-xs font-satoshi-medium text-slate-700 mb-1">
                                    Alamat Lengkap (Opsional)
                                </label>
                                <textarea name="address" rows="2" placeholder="Alamat rumah atau domisili utama..." class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-xs font-satoshi-medium text-slate-900 focus:outline-none focus:border-slate-400 transition">{{ old('address', $user->address) }}</textarea>
                            </div>
                        </div>

                        <div class="pt-2 flex justify-end">
                            <button type="submit" class="bg-[#152c4e] hover:bg-[#0f1d32] text-white font-bold py-3 px-6 rounded-2xl text-xs uppercase tracking-wider transition shadow-md flex items-center gap-2 cursor-pointer">
                                <i class="ri-save-line"></i> Simpan Perubahan Profil
                            </button>
                        </div>
                    </form>
                </div>

                <!-- CHANGE PASSWORD FORM -->
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-sm space-y-6">
                    
                    <div class="border-b border-slate-100 pb-4">
                        <h2 class="font-serif-title text-xl font-bold text-slate-900">Ubah Kata Sandi</h2>
                        <p class="text-xs text-slate-500 mt-1">Pastikan akun Anda menggunakan kata sandi yang kuat dan aman.</p>
                    </div>

                    <form action="{{ route('user.account.update') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="name" value="{{ $user->name }}">
                        <input type="hidden" name="email" value="{{ $user->email }}">

                        <div>
                            <x-ui.password 
                                name="current_password" 
                                label="Kata Sandi Saat Ini" 
                                placeholder="Masukkan kata sandi lama Anda" 
                            />
                            @error('current_password') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-ui.password 
                                    name="new_password" 
                                    label="Kata Sandi Baru" 
                                    placeholder="Minimal 8 karakter" 
                                />
                                @error('new_password') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <x-ui.password 
                                    name="new_password_confirmation" 
                                    label="Konfirmasi Kata Sandi Baru" 
                                    placeholder="Ulangi kata sandi baru" 
                                />
                            </div>
                        </div>

                        <div class="pt-2 flex justify-end">
                            <button type="submit" class="bg-[#ca9e54] hover:bg-[#b88c43] text-white font-bold py-3 px-6 rounded-2xl text-xs uppercase tracking-wider transition shadow-md flex items-center gap-2 cursor-pointer">
                                <i class="ri-lock-password-line"></i> Perbarui Kata Sandi
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>

    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success_account'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success_account') }}",
                confirmButtonColor: '#152c4e',
                customClass: { popup: 'rounded-3xl p-6 font-satoshi' }
            });
        </script>
    @endif
@endpush
