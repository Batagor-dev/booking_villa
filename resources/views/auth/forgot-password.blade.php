@extends('layouts.auth.main')

@section('title', 'Lupa Kata Sandi')
@section('subtitle', 'Masukkan alamat email Anda yang terdaftar untuk menerima tautan pemulihan kata sandi.')

@section('content')
  <div class="space-y-6">
    @if(session('status'))
      <div class="rounded-2xl border border-emerald-200 bg-emerald-50/80 p-4 text-xs font-semibold text-emerald-800 flex items-center gap-2">
        <i class="ri-checkbox-circle-line text-emerald-600 text-lg"></i>
        <span>{{ session('status') }}</span>
      </div>
    @endif

    @if($errors->any())
      <div class="rounded-2xl border border-rose-200 bg-rose-50/80 p-4 text-xs text-rose-700">
        <ul class="list-disc space-y-1 pl-5">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
      @csrf

      <x-ui.input 
        id="email" 
        name="email" 
        type="email" 
        label="Alamat Email Terdaftar"
        value="{{ old('email') }}" 
        placeholder="nama@email.com" 
        required 
        autofocus 
      />

      <button type="submit" class="w-full bg-[#152c4e] hover:bg-[#ca9e54] text-white font-satoshi-bold text-base py-3.5 px-6 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 uppercase tracking-wider cursor-pointer">
        Kirim Tautan Pemulihan
      </button>
    </form>

    <div class="text-center text-sm text-slate-600 font-satoshi-medium pt-2">
      Sudah mengingat kata sandi?
      <a href="{{ route('login') }}" class="font-satoshi-bold text-[#152c4e] hover:text-[#ca9e54] transition-colors underline ml-1">
        Masuk sekarang
      </a>
    </div>
  </div>
@endsection
