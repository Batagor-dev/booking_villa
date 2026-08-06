@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Properties';

    if (isset($property_data)) {
        $breadcrumbsData = Breadcrumbs::generate(Request::route()->getName(), $property_data);
    } else {
        $breadcrumbsData = Breadcrumbs::generate(Request::route()->getName());
    }
    $breadcrumb_parent = $breadcrumbsData->where('title', '!=', $breadcrumb->title)->last();

    $propertyTypes = [
        ['value' => 'Villa', 'label' => 'Villa'],
        ['value' => 'Resort', 'label' => 'Resort'],
        ['value' => 'Boutique Hotel', 'label' => 'Boutique Hotel'],
        ['value' => 'Apartment', 'label' => 'Apartment'],
        ['value' => 'Private House', 'label' => 'Private House'],
    ];

    $destinationOptions = isset($destinations) 
        ? $destinations->map(fn($d) => ['value' => $d->id, 'label' => $d->name])->toArray() 
        : [];

    $groupedFacilities = $facilities->groupBy('category');
    $selectedFacilityIds = old('facilities', $selected_facilities ?? []);
    
    $savedProvince = old('province', $property_data->province ?? '');
    $savedCity = old('city', $property_data->city ?? '');
    $savedMapLink = old('map_link', $property_data->map_link ?? '');
    $savedLat = old('latitude', $property_data->settings->latitude ?? '');
    $savedLng = old('longitude', $property_data->settings->longitude ?? '');
@endphp

@extends('layouts.backend.main')

@section('title', 'Property Form')
@section('sub_title', $sub_title)

@section('breadcrumb')
    <x-layout.admin.breadcrumb :breadcrumbs="$breadcrumbsData" />
@endsection

@section('content')
    <div x-data="{ activeTab: 'general' }" class="space-y-6 pb-12">
        <form method="POST" action="{{ $action }}" class="space-y-6" enctype="multipart/form-data">
            @isset($property_data) @method('PUT') @endisset
            @csrf

            <!-- Navigation Tabs Header -->
            <div class="bg-white rounded-3xl p-2 shadow-lg shadow-slate-100/50 border border-slate-200/80 flex flex-wrap gap-2">
                <button type="button" 
                        @click="activeTab = 'general'" 
                        :class="activeTab === 'general' ? 'bg-slate-900 text-white font-satoshi-medium shadow-sm' : 'text-slate-600 hover:bg-slate-100 font-satoshi-medium'"
                        class="flex items-center gap-2 px-5 py-3 rounded-2xl text-sm transition-all duration-200">
                    <i class="ri-information-line text-lg"></i> General Info & Location
                </button>

                <button type="button" 
                        @click="activeTab = 'facilities'" 
                        :class="activeTab === 'facilities' ? 'bg-slate-900 text-white font-satoshi-medium shadow-sm' : 'text-slate-600 hover:bg-slate-100 font-satoshi-medium'"
                        class="flex items-center gap-2 px-5 py-3 rounded-2xl text-sm transition-all duration-200">
                    <i class="ri-building-2-line text-lg"></i> Facilities & Amenities
                </button>

                <button type="button" 
                        @click="activeTab = 'settings'" 
                        :class="activeTab === 'settings' ? 'bg-slate-900 text-white font-satoshi-medium shadow-sm' : 'text-slate-600 hover:bg-slate-100 font-satoshi-medium'"
                        class="flex items-center gap-2 px-5 py-3 rounded-2xl text-sm transition-all duration-200">
                    <i class="ri-settings-4-line text-lg"></i> Settings & Policies
                </button>

                <button type="button" 
                        @click="activeTab = 'gallery'" 
                        :class="activeTab === 'gallery' ? 'bg-slate-900 text-white font-satoshi-medium shadow-sm' : 'text-slate-600 hover:bg-slate-100 font-satoshi-medium'"
                        class="flex items-center gap-2 px-5 py-3 rounded-2xl text-sm transition-all duration-200">
                    <i class="ri-image-line text-lg"></i> Photo Gallery
                </button>
            </div>

            <!-- Tab 1: General Info & Location -->
            <div x-show="activeTab === 'general'" x-transition class="space-y-6">
                <x-ui.card>
                    <h5 class="text-lg font-satoshi-bold text-slate-900 mb-6">{{ $sub_title }}</h5>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Property Name Input -->
                        <div class="md:col-span-2">
                            <x-ui.input 
                                id="property_name_input"
                                name="name" 
                                label="Property Name *" 
                                placeholder="e.g. Villa Seminyak Sanctuary" 
                                value="{{ old('name', $property_data->name ?? '') }}"
                                required
                            />
                        </div>

                        <!-- Property Code (Auto-generated from Name & Readonly) -->
                        <div>
                            <x-ui.input 
                                id="property_code_input"
                                name="code" 
                                label="Property Code (Auto)" 
                                placeholder="e.g. VSS" 
                                value="{{ old('code', $property_data->code ?? '') }}"
                                readonly
                                class="bg-slate-100/80 text-slate-600 font-bold tracking-wider cursor-not-allowed border-slate-200"
                            />
                            <span class="text-[11px] text-slate-400 mt-1 block">Karakter inisial otomatis dari Nama Properti (Maks. 3 karakter)</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                        <!-- Destination Select2 Component -->
                        <div>
                            <x-ui.select2 
                                name="destination_id" 
                                label="Destinasi / Region" 
                                placeholder="Select Destination..." 
                                :options="$destinationOptions"
                                :value="old('destination_id', $property_data->destination_id ?? '')"
                            />
                        </div>

                        <!-- Property Type Select2 Component -->
                        <div>
                            <x-ui.select2 
                                name="type" 
                                label="Property Type *" 
                                placeholder="Select Type..." 
                                :options="$propertyTypes"
                                :value="old('type', $property_data->type ?? 'Villa')"
                            />
                        </div>

                        <!-- Price Per Night (Auto Dot Separator) -->
                        <div>
                            <x-ui.price 
                                type="input"
                                id="price_input"
                                name="price" 
                                label="Harga Per Malam (IDR) *" 
                                placeholder="e.g. 2.500.000" 
                                :value="old('price', $property_data->price ?? '')"
                                required
                                inputmode="numeric"
                            />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <!-- Bedrooms -->
                        <div>
                            <x-ui.input 
                                type="number"
                                name="bedrooms" 
                                label="Kamar Tidur (Bedrooms) *" 
                                placeholder="e.g. 3" 
                                min="1"
                                value="{{ old('bedrooms', $property_data->bedrooms ?? 1) }}"
                                required
                            />
                        </div>

                        <!-- Capacity (Guests) -->
                        <div>
                            <x-ui.input 
                                type="number"
                                name="capacity" 
                                label="Kapasitas Tamu (Max Guests) *" 
                                placeholder="e.g. 6" 
                                min="1"
                                value="{{ old('capacity', $property_data->capacity ?? 2) }}"
                                required
                            />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <!-- Status / Active -->
                        <div class="flex items-center">
                            <x-ui.switch 
                                name="status" 
                                label="Active Status" 
                                value="1"
                                :checked="old('status', $property_data->status ?? true) ? true : false"
                            />
                        </div>

                        <!-- Is Featured -->
                        <div class="flex items-center">
                            <x-ui.switch 
                                name="is_featured" 
                                label="Featured Property" 
                                value="1"
                                :checked="old('is_featured', $property_data->is_featured ?? false) ? true : false"
                            />
                        </div>
                    </div>

                    <!-- Description Quill Rich Text Editor Component -->
                    <div class="mt-6">
                        <x-ui.editor 
                            name="description" 
                            label="Property Description" 
                            placeholder="Describe the property, view, ambiance, and location highlights..." 
                            :value="old('description', $property_data->description ?? '')"
                        />
                    </div>

                    <!-- Wilayah Indonesia API Select2 Cascading Pickers (Provinsi -> Kota/Kabupaten) -->
                    <div class="pt-6 border-t border-slate-100 mt-6" 
                         x-data="regionPicker({
                             initialProvince: @js($savedProvince),
                             initialCity: @js($savedCity)
                         })">
                        <h6 class="text-base font-satoshi-medium text-slate-800 mb-4 flex items-center gap-2">
                            <i class="ri-map-pin-line text-slate-600"></i> Location & Regional Address
                        </h6>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- 1. Provinsi Select2 -->
                            <div class="w-full text-left relative">
                                <label class="mb-2 block text-base font-satoshi-medium text-slate-700">
                                    Provinsi
                                    <span x-show="loadingProvinces" class="ml-2 text-xs text-slate-500 font-satoshi-medium animate-pulse"><i class="ri-loader-4-line"></i> Loading...</span>
                                </label>

                                <div class="relative">
                                    <div @click="isOpenProv = !isOpenProv; if(isOpenProv) searchProv = ''" 
                                         @click.away="isOpenProv = false"
                                         class="flex min-h-[50px] w-full items-center justify-between rounded-2xl border px-4 py-2.5 text-base font-satoshi-medium cursor-pointer outline-none transition focus-within:ring-2 border-slate-200 bg-slate-50 text-slate-900 focus-within:border-slate-400 focus-within:ring-slate-200">
                                        
                                        <div class="flex flex-wrap gap-1.5 items-center w-full overflow-hidden">
                                            <template x-if="!selectedProvince">
                                                <span class="text-slate-400 font-satoshi-medium">-- Pilih Provinsi --</span>
                                            </template>

                                            <template x-if="selectedProvince">
                                                <div class="flex items-center justify-between w-full min-w-0">
                                                    <span class="text-slate-900 truncate" x-text="selectedProvince"></span>
                                                    <button type="button" @click.stop="onProvinceChange('')" class="text-slate-400 hover:text-slate-600 font-satoshi-medium ml-2 text-sm leading-none p-1 rounded-md hover:bg-slate-200/50 flex-shrink-0" title="Clear">&times;</button>
                                                </div>
                                            </template>
                                        </div>

                                        <svg class="w-4 h-4 text-slate-400 transition-transform shrink-0 ml-2" :class="isOpenProv ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>

                                    <input type="hidden" name="province" :value="selectedProvince">

                                    <!-- Dropdown -->
                                    <div x-show="isOpenProv" 
                                         x-transition
                                         class="absolute z-50 mt-2 w-full bg-white border border-slate-200 rounded-2xl shadow-lg max-h-60 overflow-y-auto p-2" 
                                         style="display: none;">
                                        
                                        <div class="sticky top-0 bg-white pb-2 pt-0.5">
                                            <input type="text" 
                                                   x-model="searchProv" 
                                                   placeholder="Search Provinsi..." 
                                                   class="w-full px-3 py-2 text-sm font-satoshi-medium bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-slate-400 focus:bg-white transition"
                                                   @click.stop />
                                        </div>

                                        <ul class="space-y-0.5">
                                            <template x-for="prov in filteredProvinces" :key="prov.id">
                                                <li @click="onProvinceChange(prov.name); isOpenProv = false"
                                                    class="px-3 py-2 text-sm rounded-lg cursor-pointer transition flex items-center justify-between"
                                                    :class="prov.name === selectedProvince ? 'bg-slate-100 text-slate-900 font-satoshi-medium' : 'text-slate-700 hover:bg-slate-50'">
                                                    <span x-text="prov.name" class="font-satoshi-medium"></span>
                                                    
                                                    <template x-if="prov.name === selectedProvince">
                                                        <svg class="w-4 h-4 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </template>
                                                </li>
                                            </template>
                                            
                                            <template x-if="filteredProvinces.length === 0">
                                                <li class="px-3 py-4 text-sm text-center text-slate-400 font-satoshi-medium">Data tidak ditemukan</li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Kota / Kabupaten Select2 -->
                            <div class="w-full text-left relative">
                                <label class="mb-2 block text-base font-satoshi-medium text-slate-700">
                                    Kota / Kabupaten
                                    <span x-show="loadingRegencies" class="ml-2 text-xs text-slate-500 font-satoshi-medium animate-pulse"><i class="ri-loader-4-line"></i> Loading...</span>
                                </label>

                                <div class="relative">
                                    <div @click="if(selectedProvince && !loadingRegencies) { isOpenCity = !isOpenCity; if(isOpenCity) searchCity = ''; }" 
                                         @click.away="isOpenCity = false"
                                         :class="!selectedProvince || loadingRegencies ? 'opacity-60 cursor-not-allowed bg-slate-100' : 'cursor-pointer bg-slate-50'"
                                         class="flex min-h-[50px] w-full items-center justify-between rounded-2xl border px-4 py-2.5 text-base font-satoshi-medium outline-none transition focus-within:ring-2 border-slate-200 text-slate-900 focus-within:border-slate-400 focus-within:ring-slate-200">
                                        
                                        <div class="flex flex-wrap gap-1.5 items-center w-full overflow-hidden">
                                            <template x-if="!selectedCity">
                                                <span class="text-slate-400 font-satoshi-medium" x-text="!selectedProvince ? 'Pilih Provinsi Terlebih Dahulu' : '-- Pilih Kota / Kabupaten --'"></span>
                                            </template>

                                            <template x-if="selectedCity">
                                                <div class="flex items-center justify-between w-full min-w-0">
                                                    <span class="text-slate-900 truncate" x-text="selectedCity"></span>
                                                    <button type="button" @click.stop="selectedCity = ''" class="text-slate-400 hover:text-slate-600 font-satoshi-medium ml-2 text-sm leading-none p-1 rounded-md hover:bg-slate-200/50 flex-shrink-0" title="Clear">&times;</button>
                                                </div>
                                            </template>
                                        </div>

                                        <svg class="w-4 h-4 text-slate-400 transition-transform shrink-0 ml-2" :class="isOpenCity ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>

                                    <input type="hidden" name="city" :value="selectedCity">

                                    <!-- Dropdown -->
                                    <div x-show="isOpenCity" 
                                         x-transition
                                         class="absolute z-50 mt-2 w-full bg-white border border-slate-200 rounded-2xl shadow-lg max-h-60 overflow-y-auto p-2" 
                                         style="display: none;">
                                        
                                        <div class="sticky top-0 bg-white pb-2 pt-0.5">
                                            <input type="text" 
                                                   x-model="searchCity" 
                                                   placeholder="Search Kota / Kabupaten..." 
                                                   class="w-full px-3 py-2 text-sm font-satoshi-medium bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-slate-400 focus:bg-white transition"
                                                   @click.stop />
                                        </div>

                                        <ul class="space-y-0.5">
                                            <template x-for="reg in filteredRegencies" :key="reg.id">
                                                <li @click="selectedCity = reg.name; isOpenCity = false"
                                                    class="px-3 py-2 text-sm rounded-lg cursor-pointer transition flex items-center justify-between"
                                                    :class="reg.name === selectedCity ? 'bg-slate-100 text-slate-900 font-satoshi-medium' : 'text-slate-700 hover:bg-slate-50'">
                                                    <span x-text="reg.name" class="font-satoshi-medium"></span>
                                                    
                                                    <template x-if="reg.name === selectedCity">
                                                        <svg class="w-4 h-4 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </template>
                                                </li>
                                            </template>
                                            
                                            <template x-if="filteredRegencies.length === 0">
                                                <li class="px-3 py-4 text-sm text-center text-slate-400 font-satoshi-medium">Data tidak ditemukan</li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Kode Pos -->
                            <x-ui.input 
                                name="postal_code" 
                                label="Postal Code" 
                                placeholder="e.g. 80361" 
                                value="{{ old('postal_code', $property_data->postal_code ?? '') }}"
                            />
                        </div>

                        <!-- Full Street Address -->
                        <div class="mt-6">
                            <x-ui.input 
                                name="address" 
                                label="Full Street Address" 
                                placeholder="e.g. Jl. Kayu Aya No. 88, Seminyak, Kuta, Badung Regency" 
                                value="{{ old('address', $property_data->address ?? '') }}"
                            />
                        </div>

                        <!-- Google Maps Embed Iframe Section -->
                        <div class="mt-6 p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-4"
                             x-data="mapEmbedHandler(@js($savedMapLink), @js($savedLat), @js($savedLng))">
                            <div class="flex items-center justify-between flex-wrap gap-2">
                                <label class="text-base font-satoshi-medium text-slate-800 flex items-center gap-2">
                                    <i class="ri-map-pin-2-fill text-rose-500 text-lg"></i> Google Maps Embed &amp; Link Lokasi
                                </label>

                                <template x-if="!directMapsUrl">
                                    <a href="https://www.google.com/maps" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-satoshi-medium text-slate-700 hover:text-slate-950">
                                        <i class="ri-external-link-line"></i> Buka Google Maps (Share -&gt; Embed a map)
                                    </a>
                                </template>
                            </div>

                            <!-- Hidden inputs for Latitude & Longitude automatically extracted from iframe -->
                            <input type="hidden" name="latitude" :value="extractedCoords ? extractedCoords.lat : initialLat">
                            <input type="hidden" name="longitude" :value="extractedCoords ? extractedCoords.lng : initialLng">

                            <div>
                                <div class="flex items-center justify-between gap-2 mb-2 flex-wrap">
                                    <label class="block text-xs font-satoshi-medium text-slate-700">
                                        Link Google Maps (Bisa <code class="text-rose-600 bg-rose-50 px-1 py-0.5 rounded">https://maps.app.goo.gl/...</code> atau Kode Embed <code class="text-slate-600 bg-slate-100 px-1 py-0.5 rounded">&lt;iframe&gt;</code>):
                                    </label>
                                    <button type="button" @click="generatePinEmbedFromAddress()" class="inline-flex items-center gap-1.5 text-xs font-satoshi-bold text-slate-700 hover:text-rose-600 bg-white hover:bg-rose-50 border border-slate-200 hover:border-rose-200 px-3 py-1.5 rounded-xl transition-all shadow-2xs cursor-pointer">
                                        <i class="ri-map-pin-2-fill text-rose-500"></i> Buat Pin Titik Otomatis dari Alamat
                                    </button>
                                </div>
                                <textarea 
                                    name="map_link" 
                                    x-model="rawMapLink"
                                    rows="2" 
                                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-mono text-slate-900 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200 transition placeholder:text-slate-400" 
                                    placeholder="Paste link Google Maps dari HP (misal: https://maps.app.goo.gl/tP1saEr4Q1CHLjFX7) ATAU kode <iframe>...</iframe>"
                                ></textarea>
                                <span class="text-[11px] text-slate-500 mt-1.5 block">
                                    💡 <strong>Bebas Paste:</strong> Cukup salin &amp; tempel link bagikan langsung dari aplikasi Google Maps HP Anda (misal <code>https://maps.app.goo.gl/...</code>) atau kode HTML <code>&lt;iframe&gt;</code>.
                                </span>
                            </div>



                            <!-- Live Preview Iframe Map Display -->
                            <div x-show="embedUrl" x-transition class="pt-2">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-satoshi-medium text-slate-700 flex items-center gap-1.5">
                                        <i class="ri-eye-line text-slate-600"></i> Live Preview Tampilan Maps (Iframe)
                                    </span>
                                </div>
                                <div class="w-full h-64 rounded-2xl overflow-hidden border border-slate-200 shadow-xs bg-slate-100">
                                    <iframe :src="embedUrl" class="w-full h-full border-0" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Cover Image Dropzone Component -->
                    <div class="pt-6 border-t border-slate-100 mt-6">
                        <x-ui.dropzone 
                            name="main_image" 
                            label="Main Cover Image"
                            accept="image/*"
                            :previewUrl="isset($property_data->main_image) ? asset('storage/'.$property_data->main_image) : null"
                        />
                    </div>
                </x-ui.card>
            </div>

            <!-- Tab 2: Facilities & Amenities -->
            <div x-show="activeTab === 'facilities'" x-transition class="space-y-6" style="display: none;">
                <x-ui.card>
                    <h5 class="text-lg font-satoshi-bold text-slate-900 mb-2">Select Available Facilities</h5>
                    <p class="text-xs text-slate-500 font-satoshi-medium mb-6">Pilih fasilitas master yang tersedia pada properti ini.</p>

                    @if($groupedFacilities->count() > 0)
                        <div class="space-y-6">
                            @foreach($groupedFacilities as $category => $items)
                                <div class="bg-slate-50/70 rounded-2xl p-5 border border-slate-200/80">
                                    <h6 class="text-sm font-satoshi-medium text-slate-800 uppercase tracking-wider mb-4 flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-slate-800"></span> {{ $category ?: 'General' }}
                                    </h6>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach($items as $facility)
                                            <div class="p-3 rounded-2xl bg-white border border-slate-200 transition hover:border-slate-400">
                                                <x-ui.checkbox 
                                                    name="facilities[]" 
                                                    :id="'fac_'.$facility->id"
                                                    value="{{ $facility->id }}"
                                                    :label="$facility->name"
                                                    :checked="in_array($facility->id, $selectedFacilityIds)"
                                                />
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-slate-500 font-satoshi-medium">
                            Belum ada data fasilitas master. Tambahkan fasilitas di menu <a href="{{ route('facilities.index') }}" class="text-slate-900 font-satoshi-medium underline">Facilities</a> terlebih dahulu.
                        </div>
                    @endif
                </x-ui.card>
            </div>

            <!-- Tab 3: Settings & Policies -->
            <div x-show="activeTab === 'settings'" x-transition class="space-y-6" style="display: none;">
                <x-ui.card>
                    <h5 class="text-lg font-satoshi-bold text-slate-900 mb-6">Property Operational Settings & Policies</h5>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Check In Time -->
                        <x-ui.input 
                            name="check_in_time" 
                            label="Check-In Time" 
                            placeholder="e.g. 14:00" 
                            value="{{ old('check_in_time', $property_data->settings->check_in_time ?? '14:00') }}"
                        />

                        <!-- Check Out Time -->
                        <x-ui.input 
                            name="check_out_time" 
                            label="Check-Out Time" 
                            placeholder="e.g. 12:00" 
                            value="{{ old('check_out_time', $property_data->settings->check_out_time ?? '12:00') }}"
                        />

                        <!-- Currency -->
                        <x-ui.input 
                            name="currency" 
                            label="Currency Code" 
                            placeholder="e.g. IDR, USD" 
                            value="{{ old('currency', $property_data->settings->currency ?? 'IDR') }}"
                        />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <!-- Phone -->
                        <x-ui.input 
                            name="phone" 
                            label="Contact Phone / WhatsApp" 
                            placeholder="e.g. +62 812 3456 7890" 
                            value="{{ old('phone', $property_data->settings->phone ?? '') }}"
                        />

                        <!-- Email -->
                        <x-ui.input 
                            type="email"
                            name="email" 
                            label="Contact Email" 
                            placeholder="e.g. reservation@villaseminyak.com" 
                            value="{{ old('email', $property_data->settings->email ?? '') }}"
                        />
                    </div>

                    <!-- Cancellation Policy Quill Editor Component -->
                    <div class="mt-6">
                        <x-ui.editor 
                            name="cancellation_policy" 
                            label="Cancellation Policy" 
                            placeholder="Explain deposit rules, cancellation timeframes, and refund terms..." 
                            :value="old('cancellation_policy', $property_data->settings->cancellation_policy ?? '')"
                        />
                    </div>
                </x-ui.card>
            </div>

            <!-- Tab 4: Photo Gallery -->
            <div x-show="activeTab === 'gallery'" x-transition class="space-y-6" style="display: none;">
                <x-ui.card>
                    <h5 class="text-lg font-satoshi-bold text-slate-900 mb-2">Property Photo Gallery</h5>
                    <p class="text-xs text-slate-500 font-satoshi-medium mb-6">Unggah beberapa foto kamar, kolam renang, dan sudut properti untuk dipajang di galeri.</p>

                    <!-- Existing Gallery Photos (if editing) -->
                    @if(isset($property_data) && $property_data->galleries->count() > 0)
                        <div class="mb-8">
                            <h6 class="text-sm font-satoshi-medium text-slate-800 mb-3">Foto Galeri Saat Ini:</h6>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                                @foreach($property_data->galleries as $galleryItem)
                                    <div x-data="{ isDeleted: false }" 
                                         class="relative group rounded-2xl overflow-hidden border transition-all p-1.5"
                                         :class="isDeleted ? 'border-slate-300 bg-slate-100 opacity-50' : 'border-slate-200 bg-white shadow-xs hover:border-slate-300'">
                                        
                                        <div class="relative w-full h-28 rounded-xl overflow-hidden bg-slate-100">
                                            <img src="{{ asset('storage/' . $galleryItem->image_path) }}" class="w-full h-full object-cover">
                                            
                                            <div x-show="isDeleted" class="absolute inset-0 bg-slate-900/70 flex items-center justify-center p-2 text-center">
                                                <span class="text-[11px] font-satoshi-medium text-white bg-slate-800/90 px-2 py-1 rounded-lg">Akan Dihapus</span>
                                            </div>
                                        </div>

                                        <input type="checkbox" name="delete_galleries[]" value="{{ $galleryItem->id }}" :checked="isDeleted" class="hidden">

                                        <button type="button" 
                                                @click="isDeleted = !isDeleted" 
                                                :title="isDeleted ? 'Batalkan Hapus' : 'Hapus Foto'"
                                                class="absolute top-2.5 right-2.5 h-6 w-6 rounded-full bg-slate-900/80 hover:bg-slate-950 text-white flex items-center justify-center shadow-md transition-all transform hover:scale-105">
                                            <i :class="isDeleted ? 'ri-arrow-go-back-line' : 'ri-close-line'" class="text-sm"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    @endif

                    <!-- Upload New Gallery Images using multi-image dropzone component -->
                    <div>
                        <x-ui.dropzone 
                            name="gallery_images[]" 
                            label="Upload Gallery Photos (Multiple Images)"
                            :multiple="true"
                            accept="image/*"
                        />
                    </div>
                </x-ui.card>
            </div>

            <!-- Submit / Cancel Action Buttons -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <x-ui.button type="button" font="medium" size="sm" style="secondary" onclick="window.location.href='{{ $breadcrumb_parent?->url ?? route('properties.index') }}'">
                    Cancel
                </x-ui.button>
                <x-ui.button type="submit" font="medium" size="sm">
                    Submit
                </x-ui.button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('regionPicker', (config) => ({
            provinces: [],
            regencies: [],
            selectedProvince: config.initialProvince || '',
            selectedCity: config.initialCity || '',
            loadingProvinces: false,
            loadingRegencies: false,
            isOpenProv: false,
            isOpenCity: false,
            searchProv: '',
            searchCity: '',

            async init() {
                await this.fetchProvinces();
                if (this.selectedProvince) {
                    const foundProv = this.provinces.find(p => p.name.toUpperCase() === this.selectedProvince.toUpperCase());
                    if (foundProv) {
                        await this.fetchRegencies(foundProv.id);
                    }
                }
            },

            get filteredProvinces() {
                let list = this.provinces;
                if (this.searchProv) {
                    list = list.filter(p => p.name.toLowerCase().includes(this.searchProv.toLowerCase()));
                }
                return list.slice().sort((a, b) => a.name.localeCompare(b.name));
            },

            get filteredRegencies() {
                let list = this.regencies;
                if (this.searchCity) {
                    list = list.filter(r => r.name.toLowerCase().includes(this.searchCity.toLowerCase()));
                }
                return list.slice().sort((a, b) => a.name.localeCompare(b.name));
            },

            async fetchProvinces() {
                this.loadingProvinces = true;
                try {
                    const res = await fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
                    const data = await res.json();
                    this.provinces = (data || []).sort((a, b) => a.name.localeCompare(b.name));
                } catch (e) {
                    console.error('Error fetching provinces:', e);
                } finally {
                    this.loadingProvinces = false;
                }
            },

            async onProvinceChange(provName) {
                this.selectedCity = '';
                this.regencies = [];
                const foundProv = this.provinces.find(p => p.name === provName);
                if (foundProv) {
                    this.selectedProvince = foundProv.name;
                    await this.fetchRegencies(foundProv.id);
                } else {
                    this.selectedProvince = provName;
                }
            },

            async fetchRegencies(provId) {
                this.loadingRegencies = true;
                try {
                    const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provId}.json`);
                    const data = await res.json();
                    this.regencies = (data || []).sort((a, b) => a.name.localeCompare(b.name));
                } catch (e) {
                    console.error('Error fetching regencies:', e);
                } finally {
                    this.loadingRegencies = false;
                }
            }
        }));

        Alpine.data('mapEmbedHandler', (initialLink, initialLat, initialLng) => ({
            rawMapLink: initialLink || '',
            initialLat: initialLat || '',
            initialLng: initialLng || '',
            extractedCoords: null,
            resolvedEmbedUrl: '',
            resolvedDirectUrl: '',
            isResolving: false,

            init() {
                this.$watch('rawMapLink', (val) => {
                    this.extractCoords();
                    this.resolveShortLink(val);
                });
                this.extractCoords();
                if (this.rawMapLink) {
                    this.resolveShortLink(this.rawMapLink);
                }
            },

            async resolveShortLink(text) {
                if (!text) {
                    this.resolvedEmbedUrl = '';
                    this.resolvedDirectUrl = '';
                    return;
                }

                const trimmed = text.trim();

                // If already an iframe tag, extract src
                const match = trimmed.match(/src=["']([^"']+)["']/i);
                if (match && match[1]) {
                    this.resolvedEmbedUrl = match[1];
                    this.resolvedDirectUrl = match[1];
                    return;
                }

                // If it's a URL (http/https), call backend resolver to expand short links like maps.app.goo.gl
                if (trimmed.startsWith('http')) {
                    this.isResolving = true;
                    try {
                        const res = await fetch("{{ route('properties.resolve-maps') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ url: trimmed })
                        });
                        const data = await res.json();
                        if (data.success) {
                            this.resolvedEmbedUrl = data.embed_url;
                            this.resolvedDirectUrl = data.direct_url || trimmed;
                            if (data.lat && data.lng) {
                                this.extractedCoords = { lat: data.lat, lng: data.lng };
                            }
                        }
                    } catch (e) {
                        this.resolvedEmbedUrl = `https://maps.google.com/maps?q=${encodeURIComponent(trimmed)}&t=&z=15&ie=UTF8&iwloc=&output=embed`;
                    } finally {
                        this.isResolving = false;
                    }
                }
            },

            get embedUrl() {
                if (this.resolvedEmbedUrl) return this.resolvedEmbedUrl;
                if (!this.rawMapLink) return '';
                const text = this.rawMapLink.trim();

                const matchIframe = text.match(/src=["']([^"']+)["']/i);
                if (matchIframe && matchIframe[1]) return matchIframe[1];

                return `https://maps.google.com/maps?q=${encodeURIComponent(text)}&t=&z=15&ie=UTF8&iwloc=&output=embed`;
            },

            get directMapsUrl() {
                if (this.resolvedDirectUrl) return this.resolvedDirectUrl;
                if (this.rawMapLink && this.rawMapLink.trim().startsWith('http')) return this.rawMapLink.trim();
                return 'https://www.google.com/maps';
            },

            generatePinEmbedFromAddress() {
                const addressInput = document.querySelector('input[name="address"]');
                const cityInput = document.querySelector('input[name="city"]');
                const provInput = document.querySelector('input[name="province"]');
                
                const fullAddr = [
                    addressInput ? addressInput.value : '',
                    cityInput ? cityInput.value : '',
                    provInput ? provInput.value : ''
                ].filter(Boolean).join(', ');
                
                if (!fullAddr) {
                    Swal.fire({ icon: 'warning', title: 'Alamat Kosong', text: 'Silakan isi Alamat atau Kota terlebih dahulu untuk membuat pin titik lokasi.' });
                    return;
                }
                
                const query = encodeURIComponent(fullAddr);
                this.rawMapLink = `<iframe src="https://maps.google.com/maps?q=${query}&t=&z=15&ie=UTF8&iwloc=&output=embed" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>`;
            },

            extractCoords() {
                if (!this.rawMapLink) {
                    this.extractedCoords = null;
                    return;
                }
                const latMatch = this.rawMapLink.match(/!3d(-?\d+\.\d+)/);
                const lngMatch = this.rawMapLink.match(/!4d(-?\d+\.\d+)/) || this.rawMapLink.match(/!2d(-?\d+\.\d+)/);
                
                let lat = null;
                let lng = null;
                
                if (latMatch && lngMatch) {
                    lat = latMatch[1];
                    lng = lngMatch[1];
                } else {
                    const altMatch = this.rawMapLink.match(/[@?&]q?=?(-?\d+\.\d+),(-?\d+\.\d+)/);
                    if (altMatch) {
                        lat = altMatch[1];
                        lng = altMatch[2];
                    }
                }
                
                if (lat && lng) {
                    this.extractedCoords = { lat, lng };
                } else {
                    this.extractedCoords = null;
                }
            }
        }));
    });
    </script>

    <!-- 
    ========================================================================
    AUTO-GENERATE PROPERTY CODE FROM PROPERTY NAME INITIALS (MAX 3 CHARS)
    ========================================================================
    Aturan Pembuatan Kode:
    1. Jika >= 3 Kata : Ambil huruf ke-1 dari kata 1, kata 2, dan kata 3 ("Villa Azure Sanctuary" => "VAS")
    2. Jika == 2 Kata : Ambil huruf ke-1 kata ke-1 + 2 huruf pertama kata ke-2 ("Villa Seminyak" => "VSE")
    3. Jika == 1 Kata : Ambil 3 huruf pertama dari kata tersebut ("Seminyak" => "SEM")
    ========================================================================
    -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const nameInput = document.getElementById('property_name_input') || document.querySelector('input[name="name"]');
        const codeInput = document.getElementById('property_code_input') || document.querySelector('input[name="code"]');

        if (nameInput && codeInput) {
            /**
             * Fungsi untuk menghitung 3 karakter inisial dari string Nama Properti
             */
            function generateInitialsCode(nameString) {
                if (!nameString) return '';

                // Bersihkan karakter khusus dan pecah kata berdasarkan spasi
                const cleanText = nameString.trim().replace(/[^a-zA-Z0-9\s]/g, '');
                const words = cleanText.split(/\s+/).filter(w => w.length > 0);

                let codeResult = '';

                if (words.length >= 3) {
                    // Kasus 3 kata atau lebih: Ambil huruf ke-1 dari kata 1, 2, dan 3
                    codeResult = words[0][0] + words[1][0] + words[2][0];
                } else if (words.length === 2) {
                    // Kasus 2 kata: Ambil 1 huruf kata ke-1 + 2 huruf kata ke-2
                    codeResult = words[0][0] + (words[1].length >= 2 ? words[1].substring(0, 2) : words[1]);
                } else if (words.length === 1) {
                    // Kasus 1 kata: Ambil 3 huruf pertama
                    codeResult = words[0].substring(0, 3);
                }

                return codeResult.toUpperCase();
            }

            // Real-time listener: otomatis isi input code saat user mengetik di input name
            nameInput.addEventListener('input', function () {
                codeInput.value = generateInitialsCode(this.value);
            });

            // Set nilai awal jika membuat baru dan input nama terisi
            if (nameInput.value && !codeInput.value) {
                codeInput.value = generateInitialsCode(nameInput.value);
        }
    });
    </script>

    {{-- SweetAlert otomatis --}}
    @if(session('success'))
        <script>
            Swal.fire({ icon: 'success', title: 'Success', text: "{{ session('success') }}" });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({ icon: 'error', title: 'Error', text: "{{ session('error') }}" });
        </script>
    @endif
@endpush
