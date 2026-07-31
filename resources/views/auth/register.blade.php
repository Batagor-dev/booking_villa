@extends('layouts.auth.main')

@section('title', 'Buat Akun Baru')
@section('subtitle', 'Daftarkan diri Anda untuk menikmati kemudahan reservasi & hak akses eksklusif.')

@section('content')
  <div class="space-y-6">

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
      @csrf

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <x-ui.input 
          name="name" 
          label="Nama Lengkap" 
          placeholder="Nama Anda" 
          value="{{ old('name') }}" 
          required
        />

        <x-ui.input 
          name="username" 
          label="Username" 
          placeholder="username" 
          value="{{ old('username') }}" 
          required
        />
      </div>

      <x-ui.input 
        name="email" 
        label="Alamat Email" 
        placeholder="nama@email.com" 
        value="{{ old('email') }}" 
        required
      />

      <x-ui.password 
        name="password" 
        label="Kata Sandi" 
        placeholder="Minimal 8 karakter" 
        required 
      />

      <x-ui.password 
        name="password_confirmation" 
        id="password-confirm"        
        label="Konfirmasi Kata Sandi" 
        placeholder="Ulangi kata sandi" 
        required 
      />

      <button type="submit" class="w-full bg-[#152c4e] hover:bg-[#ca9e54] text-white font-satoshi-bold text-sm py-3.5 px-6 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2 uppercase tracking-wider group cursor-pointer mt-2">
        <span>Daftar Akun Palma</span>
        <i class="ri-arrow-right-line text-lg group-hover:translate-x-1 transition-transform"></i>
      </button>
    </form>

    <!-- Social Divider -->
    <div class="relative py-1">
      <div class="absolute inset-0 flex items-center">
        <div class="w-full border-t border-slate-200/80"></div>
      </div>
      <div class="relative flex justify-center text-xs uppercase">
        <span class="bg-[#fcfbf9] px-4 text-slate-400 font-satoshi-medium tracking-wider">Atau daftar dengan</span>
      </div>
    </div>

    <!-- Google Button -->
    <div>
      <x-ui.google-button :href="route('google.login')" label="Daftar dengan Google" />
    </div>

    <!-- Sign In Link -->
    <div class="text-center text-xs text-slate-500 font-satoshi-medium pt-1">
      Sudah memiliki akun?
      <a href="{{ route('login') }}" class="font-satoshi-bold text-[#152c4e] hover:text-[#ca9e54] transition-colors underline ml-1">
        Masuk sekarang
      </a>
    </div>
  </div>
@endsection
