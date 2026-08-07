@extends('layouts.frontend.main')

@section('content')
    <!-- HERO HEADER CATALOG -->
    <section class="relative pt-32 pb-16 px-4 sm:px-6 md:px-12 bg-[#152c4e] text-white font-satoshi overflow-hidden">
        <div class="absolute inset-0 opacity-20 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1600&q=80" alt="Villa Background" class="w-full h-full object-cover">
        </div>
        <div class="max-w-7xl mx-auto text-center relative z-10 space-y-4">
            <span class="text-[10px] sm:text-xs font-bold tracking-[0.25em] text-[#e5c382] uppercase block">Eksplorasi Properti</span>
            <h1 class="font-serif-title text-3xl sm:text-5xl font-normal">Katalog Villa Mewah di Bali</h1>
            <p class="text-xs sm:text-base text-white/80 font-light max-w-2xl mx-auto">
                Temukan villa private sanctuary terbaik di Seminyak, Ubud, Uluwatu, Canggu, dan Nusa Dua yang siap memberikan pengalaman menginap tak terlupakan.
            </p>
        </div>
    </section>

    <!-- MAIN CATALOG & FILTER CONTENT -->
    <section class="py-10 sm:py-14 px-4 sm:px-6 md:px-12 max-w-7xl mx-auto font-satoshi" id="villa-catalog-section">
        
        <!-- Filter & Search Bar (Clean Card-less Layout) -->
        <div class="relative z-20 mb-10 sm:mb-12">
            <form action="{{ route('villa.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-5 items-end" id="villa-filter-form">
                
                <!-- 1. Keyword Input -->
                <div class="lg:col-span-1">
                    <label class="mb-2 block text-base font-satoshi-medium text-slate-700">Cari Kata Kunci</label>
                    <div class="flex min-h-[50px] w-full items-center rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5">
                        <i class="ri-search-line text-slate-400 text-lg mr-2 shrink-0"></i>
                        <input type="text" name="q" id="search-q" value="{{ request('q') }}" placeholder="Cari nama villa..." class="w-full bg-transparent text-base font-satoshi-medium text-slate-900 focus:outline-none placeholder:text-slate-400">
                    </div>
                </div>

                <!-- 2. Location Filter (x-ui.select2 Component) -->
                <div class="lg:col-span-1">
                    <x-ui.select2 
                        name="location" 
                        label="Lokasi Daerah" 
                        placeholder="Semua Lokasi" 
                        :options="$locationOptions ?? []" 
                        :value="request('location')" 
                    />
                </div>

                <!-- 3. Jumlah Kamar (x-ui.select2 Component) -->
                <div class="lg:col-span-1">
                    <x-ui.select2 
                        name="bedrooms" 
                        label="Jumlah Kamar" 
                        placeholder="Semua Kamar" 
                        :options="$bedroomOptions ?? []" 
                        :value="request('bedrooms')" 
                    />
                </div>

                <!-- 4. Rentang Harga & Reset Button -->
                <div class="lg:col-span-1 flex items-end gap-2">
                    <div class="flex-1">
                        <x-ui.select2 
                            name="price" 
                            label="Rentang Harga" 
                            placeholder="Semua Harga" 
                            :options="$priceOptions ?? []" 
                            :value="request('price')" 
                        />
                    </div>

                    <button type="button" onclick="resetVillaFilters()" class="min-h-[50px] px-4 bg-slate-100 text-slate-600 rounded-2xl hover:bg-slate-200 transition-colors border border-slate-200 text-xs font-semibold flex items-center justify-center shrink-0" title="Reset Filter" aria-label="Reset Filter">
                        <i class="ri-refresh-line text-lg"></i>
                    </button>
                </div>

            </form>
        </div>

        <!-- Catalog Villa Grid Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4">
            <div>
                <h2 class="font-serif-title text-2xl sm:text-3xl font-bold text-slate-900">Villa Mewah Terverifikasi</h2>
                <p class="text-xs text-slate-500 font-light mt-1" id="villa-count-text">
                    Menampilkan {{ $properties->total() ?? count($properties) }} villa terbaik dengan garansi harga resmi
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs text-slate-400 font-medium">Urutkan:</span>
                <select name="sort" id="villa-sort-select" class="bg-white border border-slate-200 text-xs font-semibold text-slate-800 rounded-full px-4 py-2 focus:outline-none cursor-pointer">
                    <option value="" {{ request('sort') == '' ? 'selected' : '' }}>Terbaru / Populer</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                </select>
            </div>
        </div>

        <!-- Villa Grid Container (Dynamic AJAX Update) -->
        <div id="villa-grid-container" class="transition-opacity duration-300">
            @include('villa.partials.grid')
        </div>

        <!-- Pagination Container (Dynamic AJAX Update) -->
        <div id="villa-pagination-container">
            @include('villa.partials.pagination')
        </div>

    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('villa-filter-form');
            const sortSelect = document.getElementById('villa-sort-select');
            const searchInput = document.getElementById('search-q');

            // Trigger AJAX when form changes (inputs or select2 hidden inputs)
            if (filterForm) {
                filterForm.addEventListener('change', function() {
                    fetchFilteredVillas();
                });
                filterForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    fetchFilteredVillas();
                });
            }

            if (sortSelect) {
                sortSelect.addEventListener('change', function() {
                    fetchFilteredVillas();
                });
            }

            // Debounced typing search
            let searchTimer;
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimer);
                    searchTimer = setTimeout(fetchFilteredVillas, 400);
                });
            }
        });

        // AJAX Fetching Function for Real-time Filtering
        function fetchFilteredVillas(url = null) {
            const form = document.getElementById('villa-filter-form');
            if (!form) return;

            const targetUrl = url || form.getAttribute('action');
            const formData = new FormData(form);
            
            const sortSelect = document.getElementById('villa-sort-select');
            if (sortSelect) {
                formData.append('sort', sortSelect.value);
            }

            const params = new URLSearchParams(formData);
            const fullUrl = targetUrl + (targetUrl.includes('?') ? '&' : '?') + params.toString();

            const container = document.getElementById('villa-grid-container');
            if (container) {
                container.classList.add('opacity-50', 'pointer-events-none');
            }

            fetch(fullUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (container) container.innerHTML = data.html;
                    
                    const pagination = document.getElementById('villa-pagination-container');
                    if (pagination) pagination.innerHTML = data.pagination;

                    const countText = document.getElementById('villa-count-text');
                    if (countText) countText.textContent = 'Menampilkan ' + data.total + ' villa terbaik dengan garansi harga resmi';
                }
            })
            .catch(err => console.error('AJAX Filter Error:', err))
            .finally(() => {
                if (container) container.classList.remove('opacity-50', 'pointer-events-none');
            });
        }

        // Reset Filter Function
        function resetVillaFilters() {
            window.location.href = "{{ route('villa.index') }}";
        }

        // Handle AJAX pagination click without page reload
        document.addEventListener('click', function(e) {
            const link = e.target.closest('#villa-pagination-container a');
            if (link) {
                e.preventDefault();
                const pageUrl = link.getAttribute('href');
                if (pageUrl) {
                    fetchFilteredVillas(pageUrl);
                    const catalogSection = document.getElementById('villa-catalog-section');
                    if (catalogSection) {
                        catalogSection.scrollIntoView({ behavior: 'smooth' });
                    }
                }
            }
        });
    </script>
@endpush
