<!-- FOOTER -->
<footer class="bg-[#0f172a] text-slate-400 pt-20 pb-12 px-6 md:px-16 border-t border-slate-800/60 font-satoshi">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12 mb-16">
            <!-- Col 1: Brand Info -->
            <div class="lg:col-span-2 space-y-5">
                <a href="{{ route('home') }}" class="inline-block">
                    <span class="font-serif-title text-2xl font-bold text-white tracking-[0.2em] uppercase">
                        PALMA
                    </span>
                </a>
                <p class="text-sm font-light text-slate-400 max-w-sm leading-relaxed">
                    {{ __('frontend.footer.tagline') }}
                </p>
                <div class="flex items-center gap-4 pt-2">
                    <a href="#" class="w-9 h-9 rounded-full border border-slate-800 hover:border-[#ca9e54] flex items-center justify-center text-slate-400 hover:text-[#ca9e54] transition-all" aria-label="Instagram">
                        <i class="ri-instagram-line text-lg"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full border border-slate-800 hover:border-[#ca9e54] flex items-center justify-center text-slate-400 hover:text-[#ca9e54] transition-all" aria-label="Facebook">
                        <i class="ri-facebook-fill text-lg"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full border border-slate-800 hover:border-[#ca9e54] flex items-center justify-center text-slate-400 hover:text-[#ca9e54] transition-all" aria-label="Twitter">
                        <i class="ri-twitter-x-line text-lg"></i>
                    </a>
                </div>
            </div>

            <!-- Col 2: Destinasi -->
            <div>
                <h4 class="text-white font-semibold text-xs tracking-[0.2em] uppercase mb-6">{{ __('frontend.footer.destinations') }}</h4>
                <ul class="space-y-3 text-sm font-light">
                    <li><a href="#" class="hover:text-white transition-colors">Seminyak, Bali</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Ubud, Bali</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Uluwatu, Bali</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Canggu, Bali</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Nusa Dua, Bali</a></li>
                </ul>
            </div>

            <!-- Col 3: Perusahaan -->
            <div>
                <h4 class="text-white font-semibold text-xs tracking-[0.2em] uppercase mb-6">{{ __('frontend.footer.company') }}</h4>
                <ul class="space-y-3 text-sm font-light">
                    <li><a href="#" class="hover:text-white transition-colors">{{ __('frontend.footer.about_us') }}</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">{{ __('frontend.footer.villa_partners') }}</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">{{ __('frontend.footer.exclusive_experiences') }}</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">{{ __('frontend.footer.journal') }}</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">{{ __('frontend.footer.contact') }}</a></li>
                </ul>
            </div>

            <!-- Col 4: Buletin -->
            <div>
                <h4 class="text-white font-semibold text-xs tracking-[0.2em] uppercase mb-6">{{ __('frontend.footer.newsletter') }}</h4>
                <p class="text-xs text-slate-400 mb-5 font-light leading-relaxed">
                    {{ __('frontend.footer.newsletter_desc') }}
                </p>
                <form class="space-y-3">
                    <input type="email" placeholder="{{ __('frontend.footer.email_placeholder') }}" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-xs text-white placeholder:text-slate-500 focus:outline-none focus:border-[#ca9e54] transition-colors">
                    <button type="submit" class="w-full bg-[#ca9e54] hover:bg-[#b88c43] text-white font-semibold text-xs uppercase tracking-wider py-3 rounded-xl transition duration-300">
                        {{ __('frontend.footer.subscribe') }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Bottom Copyright -->
        <div class="pt-8 border-t border-slate-800/80 flex flex-col md:flex-row items-center justify-between text-xs text-slate-500 gap-4">
            <p>&copy; {{ date('Y') }} Palma Luxury Villas. {{ __('frontend.footer.all_rights_reserved') }}</p>
            <div class="flex items-center gap-6">
                <a href="#" class="hover:text-slate-400 transition-colors">{{ __('frontend.footer.privacy_policy') }}</a>
                <a href="#" class="hover:text-slate-400 transition-colors">{{ __('frontend.footer.terms') }}</a>
                <a href="#" class="hover:text-slate-400 transition-colors">{{ __('frontend.footer.sitemap') }}</a>
            </div>
        </div>
    </div>
</footer>
