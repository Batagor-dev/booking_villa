@extends('layouts.auth.main')

@section('title', 'Verifikasi Kode OTP')
@section('subtitle', 'Kami telah mengirimkan 6 digit kode OTP ke email Anda.')

@section('content')
  <div class="space-y-6" x-data="{ 
      timer: 60, 
      canResend: false,
      startTimer() {
          this.canResend = false;
          this.timer = 60;
          let interval = setInterval(() => {
              if (this.timer > 0) {
                  this.timer--;
              } else {
                  this.canResend = true;
                  clearInterval(interval);
              }
          }, 1000);
      }
  }" x-init="startTimer()">

    <!-- Email Notification Info Box -->
    <div class="p-4 rounded-2xl bg-amber-50/90 border border-amber-200 flex items-start gap-3">
      <div class="w-10 h-10 rounded-xl bg-[#ca9e54] text-white flex items-center justify-center font-bold text-xl shrink-0 shadow-xs">
        <i class="ri-mail-send-line"></i>
      </div>
      <div class="text-sm text-amber-950 space-y-1">
        <p class="font-satoshi-bold">Kode OTP Terkirim</p>
        <p class="font-satoshi-medium text-amber-900 leading-relaxed">
          Kode 6 digit telah dikirim ke <strong class="text-slate-900 font-satoshi-bold">{{ auth()->user()->email ?? 'email Anda' }}</strong>. Berlaku selama 10 menit.
        </p>
      </div>
    </div>

    <!-- Status Alert Messages -->
    @if(session('status'))
      <div class="rounded-2xl border border-emerald-200 bg-emerald-50/90 p-4 text-sm font-satoshi-semibold text-emerald-800 flex items-center gap-2.5">
        <i class="ri-checkbox-circle-fill text-emerald-600 text-lg shrink-0"></i>
        <span>{{ session('status') }}</span>
      </div>
    @endif

    @if($errors->has('otp_code'))
      <div class="rounded-2xl border border-rose-200 bg-rose-50/90 p-4 text-sm font-satoshi-semibold text-rose-800 flex items-center gap-2.5">
        <i class="ri-error-warning-fill text-rose-600 text-lg shrink-0"></i>
        <span>{{ $errors->first('otp_code') }}</span>
      </div>
    @endif

    <!-- OTP Verification Form -->
    <form method="POST" action="{{ route('verification.otp.verify') }}" class="space-y-5">
      @csrf

      <div>
        <label for="otp_code" class="block text-sm font-satoshi-bold text-slate-800 uppercase tracking-wider mb-2 text-center lg:text-left">
          Masukkan 6 Digit Kode OTP
        </label>
        
        <div class="relative">
          <input 
            id="otp_code" 
            name="otp_code" 
            type="text" 
            inputmode="numeric"
            pattern="[0-9]*"
            maxlength="6"
            value="{{ old('otp_code') }}" 
            placeholder="• • • • • •" 
            required 
            autofocus 
            autocomplete="one-time-code"
            class="w-full text-center font-mono text-3xl font-bold tracking-[0.5em] py-4 px-4 rounded-2xl border-2 border-slate-300 bg-white text-slate-900 outline-none transition-all focus:border-[#ca9e54] focus:ring-4 focus:ring-[#ca9e54]/15 shadow-xs"
          />
        </div>
      </div>

      <button type="submit" class="w-full bg-[#152c4e] hover:bg-[#ca9e54] text-white font-satoshi-bold text-base py-3.5 px-6 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 uppercase tracking-wider cursor-pointer">
        Verifikasi OTP Sekarang
      </button>
    </form>

    <!-- Resend OTP Form with Cooldown Timer -->
    <div class="pt-2 border-t border-slate-200 text-center">
      <form method="POST" action="{{ route('verification.otp.resend') }}">
        @csrf
        <p class="text-sm text-slate-600 font-satoshi-medium mb-3">
          Tidak menerima kode atau OTP kadaluarsa?
        </p>

        <button 
          type="submit" 
          :disabled="!canResend"
          :class="canResend ? 'bg-slate-900 text-white hover:bg-[#ca9e54] cursor-pointer shadow-sm' : 'bg-slate-100 text-slate-400 cursor-not-allowed'"
          class="w-full font-satoshi-bold text-sm uppercase tracking-wider py-3.5 px-4 rounded-2xl transition-all duration-300 flex items-center justify-center gap-2"
        >
          <span x-show="canResend">Kirim Ulang Kode OTP</span>
          <span x-show="!canResend" x-text="'Kirim Ulang dalam ' + timer + ' detik'"></span>
        </button>
      </form>

      <!-- Logout / Switch Account -->
      <div class="mt-4">
        <form method="POST" action="{{ route('logout') }}" class="inline">
          @csrf
          <button type="submit" class="text-sm font-satoshi-semibold text-slate-600 hover:text-rose-600 transition-colors inline-flex items-center gap-1.5 cursor-pointer">
            <span>Keluar atau Gunakan Akun Lain</span>
          </button>
        </form>
      </div>
    </div>

  </div>
@endsection
