@extends('layouts.auth.main')

@section('title', 'Atur Ulang Kata Sandi')
@section('subtitle', 'Buat kata sandi baru yang aman untuk akun Palma Anda.')

@section('content')
  <div class="space-y-6">
    @if($errors->any())
      <div class="rounded-2xl border border-rose-200 bg-rose-50/80 p-4 text-xs text-rose-700">
        <ul class="list-disc space-y-1 pl-5">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
      @csrf

      <input type="hidden" name="token" value="{{ $request->route('token') }}" />

      <x-ui.input id="email" name="email" type="email" value="{{ old('email', $request->email) }}" placeholder="nama@email.com" required label="Alamat Email" />

      <x-ui.password id="password" name="password" placeholder="••••••••" required label="Kata Sandi Baru" />

      <x-ui.password id="password_confirmation" name="password_confirmation" placeholder="••••••••" required label="Konfirmasi Kata Sandi Baru" />

      <button type="submit" class="w-full bg-[#152c4e] hover:bg-[#ca9e54] text-white font-satoshi-bold text-sm py-3.5 px-6 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2 uppercase tracking-wider group cursor-pointer mt-2">
        <span>Simpan Kata Sandi Baru</span>
        <i class="ri-check-line text-lg group-hover:scale-110 transition-transform"></i>
      </button>
    </form>

    <div class="text-center text-xs text-slate-500 font-satoshi-medium pt-1">
      Kembali ke halaman masuk?
      <a href="{{ route('login') }}" class="font-satoshi-bold text-[#152c4e] hover:text-[#ca9e54] transition-colors underline ml-1">
        Masuk sekarang
      </a>
    </div>
  </div>
@endsection
