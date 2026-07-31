@extends('layouts.auth.main')

@section('title', 'Masuk Akun')
@section('subtitle', 'Silakan masukkan kredensial Anda untuk mengakses layanan eksklusif.')

@section('content')
  <div class="space-y-6">
    @if(session('status'))
      <div class="rounded-2xl border border-emerald-200 bg-emerald-50/80 p-4 text-xs font-semibold text-emerald-800 flex items-center gap-2">
        <i class="ri-checkbox-circle-line text-emerald-600 text-lg"></i>
        <span>{{ session('status') }}</span>
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
      @csrf

      <x-ui.input 
        name="email" 
        label="Alamat Email" 
        placeholder="nama@email.com" 
        value="{{ old('email') }}" 
        required
        autofocus
      />

      <x-ui.password 
        name="password" 
        label="Kata Sandi" 
        placeholder="••••••••" 
        required 
      />

      <div class="flex items-center justify-between text-sm pt-1">
        <x-ui.checkbox name="remember" label="Ingat saya" size="sm" />
        <a href="{{ route('password.request') ?? '#' }}" class="text-sm font-satoshi-bold text-[#ca9e54] hover:text-[#b88c43] transition-colors hover:underline">
          Lupa kata sandi?
        </a>
      </div>

      <button type="submit" class="w-full bg-[#152c4e] hover:bg-[#ca9e54] text-white font-satoshi-bold text-base py-3.5 px-6 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 uppercase tracking-wider cursor-pointer">
        Masuk Sekarang
      </button>
    </form>

    <!-- Social Divider -->
    <div class="relative py-2">
      <div class="absolute inset-0 flex items-center">
        <div class="w-full border-t border-slate-200"></div>
      </div>
      <div class="relative flex justify-center text-xs uppercase">
        <span class="bg-[#fcfbf9] px-4 text-slate-500 font-satoshi-semibold tracking-wider">Atau masuk dengan</span>
      </div>
    </div>

    <!-- Google Login Button -->
    <div>
      <x-ui.google-button :href="route('google.login')" label="Lanjutkan dengan Google" />
    </div>

    <!-- Sign Up Callout -->
    <div class="text-center text-sm text-slate-600 font-satoshi-medium pt-2">
      Belum memiliki akun?
      <a href="{{ route('register') }}" class="font-satoshi-bold text-[#152c4e] hover:text-[#ca9e54] transition-colors underline ml-1">
        Daftar sekarang
      </a>
    </div>
  </div>
@endsection
