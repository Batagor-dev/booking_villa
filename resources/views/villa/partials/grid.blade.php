@if(isset($properties) && $properties->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        @foreach($properties as $villa)
            <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col">
                <div class="relative h-60 overflow-hidden bg-slate-100">
                    <img src="{{ $villa->main_image ? asset('storage/' . $villa->main_image) : 'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=600&q=75' }}" alt="{{ $villa->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-4 left-4 flex gap-2">
                        <span class="bg-[#ca9e54] text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-md uppercase">{{ $villa->code ?? 'PLM' }}</span>
                        <span class="bg-white/90 backdrop-blur-md text-slate-800 text-[10px] font-semibold px-2.5 py-1 rounded-full shadow-md">{{ $villa->type ?? 'Villa' }}</span>
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <a href="{{ route('villa.show', $villa->slug) }}" class="font-serif-title text-xl font-bold text-slate-900 group-hover:text-[#152c4e] transition-colors line-clamp-1">{{ $villa->name }}</a>
                            <div class="flex items-center gap-1 text-xs font-semibold text-slate-700 shrink-0 ml-2">
                                <i class="ri-star-fill text-[#ca9e54]"></i>
                                <span>{{ number_format($villa->rating ?? 4.9, 1) }}</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 flex items-center gap-1.5 mb-4">
                            <i class="ri-map-pin-line text-slate-400 text-sm"></i> {{ $villa->city ?? 'Seminyak' }}, {{ $villa->province ?? 'Bali' }}
                        </p>
                        <div class="flex items-center justify-between text-xs text-slate-600 pt-3 border-t border-slate-100 mb-5 font-medium">
                            <span class="flex items-center gap-1"><i class="ri-hotel-bed-line text-[#ca9e54]"></i> {{ $villa->bedrooms }} Kamar</span>
                            <span class="flex items-center gap-1"><i class="ri-group-line text-[#ca9e54]"></i> {{ $villa->capacity }} Tamu</span>
                        </div>
                    </div>
                    <div class="flex items-baseline justify-between pt-2 border-t border-slate-100">
                        <div>
                            <x-ui.price :value="$villa->price" class="text-xl font-bold text-[#152c4e]" />
                            <span class="text-xs font-normal text-slate-500">/ malam</span>
                        </div>
                        <a href="{{ route('villa.show', $villa->slug) }}" class="bg-[#152c4e] hover:bg-[#ca9e54] text-white text-xs font-bold px-4 py-2 rounded-full transition-colors">Pesan</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="py-16 text-center space-y-4 max-w-xl mx-auto">
        <div class="w-14 h-14 rounded-full bg-[#ca9e54]/10 text-[#ca9e54] flex items-center justify-center text-2xl mx-auto">
            <i class="ri-search-line"></i>
        </div>
        <h3 class="font-serif-title text-2xl font-bold text-slate-900">Tidak Ada Villa yang Ditemukan</h3>
        <p class="text-xs sm:text-sm text-slate-500 font-light leading-relaxed">
            Maaf, kami tidak menemukan villa yang sesuai dengan kombinasi filter Anda. Coba ubah kata kunci atau reset filter.
        </p>
        <div class="pt-2">
            <button type="button" onclick="resetVillaFilters()" class="inline-flex items-center gap-2 bg-[#152c4e] hover:bg-[#ca9e54] text-white font-bold px-6 py-2.5 rounded-full text-xs transition-colors cursor-pointer shadow-md">
                <i class="ri-refresh-line"></i> Reset Filter
            </button>
        </div>
    </div>
@endif
