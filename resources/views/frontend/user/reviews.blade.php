@extends('layouts.frontend.main')

@section('title', 'Ulasan Saya & Rating - Palma Luxury')

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
                <a href="{{ route('user.account') }}" class="hover:text-[#ca9e54] transition-colors">Portal Pelanggan</a>
                <span>/</span>
                <span class="text-white font-semibold">Ulasan Saya</span>
            </div>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <span class="text-[10px] sm:text-xs font-bold tracking-[0.25em] text-[#e5c382] uppercase block mb-1">Portal Pelanggan</span>
                    <h1 class="font-serif-title text-3xl sm:text-4xl md:text-5xl font-normal text-white">
                        Ulasan & Rating Saya
                    </h1>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('user.bookings') }}" class="px-5 py-2.5 rounded-full bg-white/10 hover:bg-white/20 text-white text-xs font-bold transition border border-white/20 flex items-center gap-1.5">
                        <i class="ri-history-line text-sm"></i> Lihat Reservasi Saya
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- MAIN REVIEWS CONTENT -->
    <section class="py-10 sm:py-14 px-4 sm:px-6 md:px-12 max-w-7xl mx-auto font-satoshi" x-data="{ createModalOpen: false, editModalOpen: false, editData: {} }">
        
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-medium flex items-center gap-3">
                <i class="ri-checkbox-circle-fill text-emerald-500 text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm font-medium flex items-center gap-3">
                <i class="ri-error-warning-fill text-rose-500 text-lg"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- UNREVIEWED BOOKINGS BANNER (If any) -->
        @if($reviewableBookings->count() > 0)
            <div class="mb-8 p-6 rounded-3xl bg-gradient-to-r from-[#152c4e] to-[#1e3a63] text-white shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="space-y-1">
                    <span class="inline-flex items-center gap-1 text-[10px] uppercase tracking-widest text-[#ca9e54] font-bold">
                        <i class="ri-star-smile-fill"></i> Reservasi Selesai
                    </span>
                    <h3 class="font-serif-title text-xl font-bold">Anda Memiliki {{ $reviewableBookings->count() }} Reservasi Yang Belum Diulas!</h3>
                    <p class="text-xs text-slate-300">Bagikan pengalaman tinggal Anda untuk membantu tamu lain dan mendapatkan layanan terbaik kami.</p>
                </div>
                <div class="shrink-0">
                    <button type="button" @click="createModalOpen = true" class="px-5 py-2.5 rounded-full bg-[#ca9e54] hover:bg-[#b88c43] text-white text-xs font-bold transition shadow-md flex items-center gap-1.5 cursor-pointer">
                        <i class="ri-add-line text-base"></i> Tulis Ulasan Sekarang
                    </button>
                </div>
            </div>
        @endif

        <!-- REVIEWS LIST SECTION -->
        <div class="space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-200">
                <h3 class="font-serif-title text-2xl font-bold text-slate-900">Riwayat Ulasan Pelanggan</h3>
                <span class="text-xs text-slate-500 font-medium">Total {{ $reviews->total() }} Ulasan</span>
            </div>

            @if($reviews->count() > 0)
                <div class="space-y-6">
                    @foreach($reviews as $rev)
                        @php
                            $prop = $rev->property;
                            $isEditable = $rev->isEditableByCustomer();
                        @endphp

                        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition space-y-4">
                            
                            <!-- Header Row: Property Info & Status -->
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
                                <div class="flex items-center gap-4">
                                    <img src="{{ $prop ? $prop->main_image_url : asset('images/no-image.png') }}" alt="{{ $prop->name ?? 'Villa' }}" class="w-14 h-14 rounded-2xl object-cover border border-slate-100 shrink-0">
                                    <div>
                                        <a href="{{ route('villa.show', $prop->slug ?? '') }}" class="font-serif-title text-base font-bold text-slate-900 hover:text-[#ca9e54] transition-colors">
                                            {{ $prop->name ?? 'Villa' }}
                                        </a>
                                        <div class="flex items-center gap-2 text-xs text-slate-400 mt-0.5">
                                            <span>{{ $prop->city ?? 'Bali' }}</span>
                                            @if($rev->booking)
                                                <span>•</span>
                                                <span class="font-mono text-slate-500">#{{ $rev->booking->booking_code }}</span>
                                            @endif
                                            <span>•</span>
                                            <span>{{ $rev->created_at->format('d M Y, H:i') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Badge -->
                                <div class="flex items-center gap-2">
                                    @if($rev->status === 'approved')
                                        <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold flex items-center gap-1">
                                            <i class="ri-checkbox-circle-fill text-emerald-500"></i> Dipublikasikan
                                        </span>
                                    @elseif($rev->status === 'pending')
                                        <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-800 border border-amber-200 text-xs font-bold flex items-center gap-1">
                                            <i class="ri-time-fill text-amber-500"></i> Menunggu Moderasi
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full bg-rose-50 text-rose-700 border border-rose-200 text-xs font-bold flex items-center gap-1">
                                            <i class="ri-close-circle-fill text-rose-500"></i> Ditolak / Dihapus
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Rating & Comment Body -->
                            <div class="space-y-3">
                                <div class="flex items-center gap-2">
                                    <div class="flex text-[#ca9e54] text-base">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="{{ $i <= $rev->rating ? 'ri-star-fill' : 'ri-star-line text-slate-200' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="text-xs font-bold text-slate-700">({{ $rev->rating }}.0 / 5.0)</span>
                                    @if($rev->title)
                                        <span class="text-xs text-slate-400">•</span>
                                        <h5 class="text-xs font-bold text-slate-800">{{ $rev->title }}</h5>
                                    @endif
                                </div>

                                <p class="text-xs sm:text-sm text-slate-600 font-light leading-relaxed">
                                    "{{ $rev->comment }}"
                                </p>
                            </div>

                            <!-- ADMIN REPLY BOX (If any) -->
                            @if(!empty($rev->admin_reply))
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2 mt-3">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-[#152c4e] text-[#ca9e54] flex items-center justify-center text-xs font-bold">P</div>
                                            <span class="text-xs font-bold text-slate-900">Balasan Resmi Pengelola Palma Villa</span>
                                        </div>
                                        <span class="text-[10px] text-slate-400">
                                            {{ $rev->admin_replied_at ? $rev->admin_replied_at->format('d M Y, H:i') : '' }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-600 italic leading-relaxed pl-8">
                                        "{{ $rev->admin_reply }}"
                                    </p>
                                </div>
                            @endif

                            <!-- ACTION BUTTONS ROW -->
                            <div class="flex items-center justify-between pt-3 border-t border-slate-100 text-xs">
                                <div class="text-[11px] text-slate-400">
                                    @if($isEditable)
                                        <span class="text-emerald-600 font-medium flex items-center gap-1">
                                            <i class="ri-time-line"></i> Dapat diedit (berakhir {{ $rev->created_at->addDays(7)->diffForHumans() }})
                                        </span>
                                    @else
                                        <span class="text-slate-400">Tersimpan permanen (> 7 hari)</span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2">
                                    @if($isEditable)
                                        <button type="button" 
                                                @click="editData = { uuid: '{{ $rev->uuid }}', rating: {{ $rev->rating }}, title: '{{ addslashes($rev->title ?? '') }}', comment: '{{ addslashes($rev->comment) }}', actionUrl: '{{ route('reviews.update', $rev->uuid) }}' }; editModalOpen = true" 
                                                class="px-3.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition flex items-center gap-1 cursor-pointer">
                                            <i class="ri-edit-line text-sm"></i> Edit
                                        </button>
                                    @endif

                                    <!-- Soft Delete Form -->
                                    <form action="{{ route('reviews.destroy', $rev->uuid) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold transition flex items-center gap-1 cursor-pointer">
                                            <i class="ri-delete-bin-line text-sm"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                <!-- PAGINATION -->
                <div class="pt-4">
                    {{ $reviews->links() }}
                </div>
            @else
                <div class="bg-white rounded-3xl p-12 border border-slate-100 text-center space-y-4">
                    <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-2xl">
                        <i class="ri-chat-smile-2-line"></i>
                    </div>
                    <div class="space-y-1">
                        <h4 class="font-serif-title text-xl font-bold text-slate-800">Belum Ada Ulasan</h4>
                        <p class="text-xs text-slate-500">Anda belum pernah menulis ulasan untuk reservasi villa Anda.</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- MODAL: WRITE NEW REVIEW -->
        <div x-show="createModalOpen" 
             x-transition 
             class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4"
             style="display: none;">
            <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-6 shadow-2xl relative" @click.away="createModalOpen = false">
                <button type="button" @click="createModalOpen = false" class="absolute top-5 right-5 text-slate-400 hover:text-slate-600">
                    <i class="ri-close-line text-2xl"></i>
                </button>

                <div>
                    <span class="text-[10px] font-bold text-[#ca9e54] tracking-widest uppercase">FORM ULASAN</span>
                    <h3 class="font-serif-title text-2xl font-bold text-slate-900">Tulis Ulasan & Experience</h3>
                </div>

                <form action="{{ route('reviews.store') }}" method="POST" class="space-y-4" x-data="{ selectedRating: 5 }">
                    @csrf

                    <!-- Select Booking / Property -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Pilih Reservasi Villa</label>
                        @if($reviewableBookings->count() > 0)
                            <select name="booking_id" required @change="
                                let opt = $event.target.options[$event.target.selectedIndex];
                                $refs.propertyIdInput.value = opt.getAttribute('data-property-id');
                            " class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-medium text-slate-800 focus:outline-none focus:border-[#152c4e]">
                                <option value="" disabled selected>-- Pilih Reservasi --</option>
                                @foreach($reviewableBookings as $rb)
                                    <option value="{{ $rb->id }}" data-property-id="{{ $rb->property_id }}">
                                        {{ $rb->property->name ?? 'Villa' }} (#{{ $rb->booking_code }} - {{ $rb->check_in->format('d M Y') }})
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="property_id" x-ref="propertyIdInput">
                        @else
                            <p class="text-xs text-amber-600 bg-amber-50 p-3 rounded-xl border border-amber-200">
                                Anda tidak memiliki riwayat reservasi yang belum diulas. Ulasan umum akan dikirimkan.
                            </p>
                        @endif
                    </div>

                    <!-- Rating Stars Selection -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Berikan Rating Bintang</label>
                        <div class="flex items-center gap-2 text-2xl text-[#ca9e54]">
                            <template x-for="star in 5">
                                <button type="button" @click="selectedRating = star" class="focus:outline-none cursor-pointer">
                                    <i :class="star <= selectedRating ? 'ri-star-fill' : 'ri-star-line text-slate-200'"></i>
                                </button>
                            </template>
                            <span class="text-xs font-bold text-slate-700 ml-2" x-text="selectedRating + ' / 5 Star'"></span>
                        </div>
                        <input type="hidden" name="rating" :value="selectedRating">
                    </div>

                    <!-- Title -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Judul Ulasan (Opsional)</label>
                        <input type="text" name="title" placeholder="Contoh: Staycation Luar Biasa & Kolam Bersih" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-medium text-slate-800 focus:outline-none focus:border-[#152c4e]">
                    </div>

                    <!-- Comment -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Komentar / Pengalaman Anda</label>
                        <textarea name="comment" rows="4" required placeholder="Ceritakan bagaimana pengalaman menginap Anda..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-medium text-slate-800 focus:outline-none focus:border-[#152c4e]"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" @click="createModalOpen = false" class="px-5 py-2.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2.5 rounded-full bg-[#ca9e54] hover:bg-[#b88c43] text-white text-xs font-bold transition shadow-md cursor-pointer">
                            Kirim Ulasan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- MODAL: EDIT EXISTING REVIEW -->
        <div x-show="editModalOpen" 
             x-transition 
             class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4"
             style="display: none;">
            <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-6 shadow-2xl relative" @click.away="editModalOpen = false">
                <button type="button" @click="editModalOpen = false" class="absolute top-5 right-5 text-slate-400 hover:text-slate-600">
                    <i class="ri-close-line text-2xl"></i>
                </button>

                <div>
                    <span class="text-[10px] font-bold text-[#ca9e54] tracking-widest uppercase">EDIT ULASAN</span>
                    <h3 class="font-serif-title text-2xl font-bold text-slate-900">Perbarui Ulasan Anda</h3>
                </div>

                <form :action="editData.actionUrl" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Rating Stars Selection -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Rating Bintang</label>
                        <div class="flex items-center gap-2 text-2xl text-[#ca9e54]">
                            <template x-for="star in 5">
                                <button type="button" @click="editData.rating = star" class="focus:outline-none cursor-pointer">
                                    <i :class="star <= editData.rating ? 'ri-star-fill' : 'ri-star-line text-slate-200'"></i>
                                </button>
                            </template>
                            <span class="text-xs font-bold text-slate-700 ml-2" x-text="editData.rating + ' / 5 Star'"></span>
                        </div>
                        <input type="hidden" name="rating" :value="editData.rating">
                    </div>

                    <!-- Title -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Judul Ulasan</label>
                        <input type="text" name="title" x-model="editData.title" placeholder="Judul ulasan..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-medium text-slate-800 focus:outline-none focus:border-[#152c4e]">
                    </div>

                    <!-- Comment -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Komentar / Ulasan</label>
                        <textarea name="comment" rows="4" required x-model="editData.comment" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-medium text-slate-800 focus:outline-none focus:border-[#152c4e]"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" @click="editModalOpen = false" class="px-5 py-2.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2.5 rounded-full bg-[#152c4e] hover:bg-[#0f1d32] text-white text-xs font-bold transition shadow-md cursor-pointer">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </section>
@endsection
