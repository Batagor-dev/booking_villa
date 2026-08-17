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

    $transId = isset($property_data) && $property_data->relationLoaded('translations') ? $property_data->translations->firstWhere('locale', 'id') : null;
    $transEn = isset($property_data) && $property_data->relationLoaded('translations') ? $property_data->translations->firstWhere('locale', 'en') : null;
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
                        :class="activeTab === 'general' ? 'bg-slate-900 text-white font-satoshi-bold shadow-xs' : 'text-slate-600 hover:bg-slate-100 font-satoshi-medium'"
                        class="flex items-center gap-2 px-5 py-3 rounded-2xl text-sm transition-all duration-200 cursor-pointer">
                    <i class="ri-information-line text-lg"></i> General Info &amp; Location
                </button>

                <button type="button" 
                        @click="activeTab = 'facilities'" 
                        :class="activeTab === 'facilities' ? 'bg-slate-900 text-white font-satoshi-bold shadow-xs' : 'text-slate-600 hover:bg-slate-100 font-satoshi-medium'"
                        class="flex items-center gap-2 px-5 py-3 rounded-2xl text-sm transition-all duration-200 cursor-pointer">
                    <i class="ri-building-2-line text-lg"></i> Facilities &amp; Amenities
                </button>

                <button type="button" 
                        @click="activeTab = 'settings'" 
                        :class="activeTab === 'settings' ? 'bg-slate-900 text-white font-satoshi-bold shadow-xs' : 'text-slate-600 hover:bg-slate-100 font-satoshi-medium'"
                        class="flex items-center gap-2 px-5 py-3 rounded-2xl text-sm transition-all duration-200 cursor-pointer">
                    <i class="ri-settings-4-line text-lg"></i> Settings &amp; Policies
                </button>

                <button type="button" 
                        @click="activeTab = 'gallery'" 
                        :class="activeTab === 'gallery' ? 'bg-slate-900 text-white font-satoshi-bold shadow-xs' : 'text-slate-600 hover:bg-slate-100 font-satoshi-medium'"
                        class="flex items-center gap-2 px-5 py-3 rounded-2xl text-sm transition-all duration-200 cursor-pointer">
                    <i class="ri-image-line text-lg"></i> Photo Gallery
                </button>
            </div>

            <!-- ========================================================================= -->
            <!-- TAB 1: GENERAL INFO & LOCATION                                           -->
            <!-- ========================================================================= -->
            <div x-show="activeTab === 'general'" x-transition class="space-y-6">
                <!-- CARD: INFORMASI UTAMA & DETAIL PROPERTI -->
                <x-ui.card class="p-6">
                    <div class="border-b border-slate-100 pb-4 mb-6">
                        <h5 class="text-base font-satoshi-bold text-slate-900 flex items-center gap-2">
                            <i class="ri-home-5-line text-[#ca9e54] text-lg"></i> {{ $sub_title }}
                        </h5>
                        <p class="text-xs text-slate-500 mt-0.5">Informasi utama properti, nama, deskripsi, kapasitas, serta tarif sewa per malam.</p>
                    </div>

                    <div class="space-y-6">
                        <!-- Konten Bahasa Indonesia (Default) -->
                        <div class="p-5 rounded-2xl bg-slate-50/80 border border-slate-200/90 space-y-4">
                            <div class="flex items-center gap-2 border-b border-slate-200/80 pb-3">
                                <span class="text-base">🇮🇩</span>
                                <div>
                                    <h6 class="text-sm font-satoshi-bold text-slate-900">Konten Bahasa Indonesia (Default)</h6>
                                    <p class="text-[11px] text-slate-500">Nama dan deskripsi properti dalam Bahasa Indonesia.</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="md:col-span-2">
                                    <x-ui.input 
                                        id="property_name_input"
                                        name="name" 
                                        label="Nama Properti (ID) *" 
                                        placeholder="e.g. Villa Seminyak Sanctuary" 
                                        value="{{ old('name', $transId->name ?? ($property_data->name ?? '')) }}"
                                        required
                                    />
                                </div>
                                <div>
                                    <x-ui.input 
                                        id="property_code_input"
                                        name="code" 
                                        label="Kode Properti (Auto)" 
                                        placeholder="e.g. VSS" 
                                        value="{{ old('code', $property_data->code ?? '') }}"
                                        readonly
                                        class="bg-slate-100/80 text-slate-600 font-bold tracking-wider cursor-not-allowed border-slate-200"
                                    />
                                    <span class="text-[11px] text-slate-400 mt-1 block">Inisial otomatis dari Nama Properti</span>
                                </div>
                            </div>

                            <div>
                                <x-ui.editor 
                                    name="description" 
                                    label="Deskripsi Properti (ID)" 
                                    placeholder="Deskripsikan keindahan, fasilitas, dan keunikan properti ini..." 
                                    :value="old('description', $transId->description ?? ($property_data->description ?? ''))"
                                />
                            </div>
                        </div>

                        <!-- Konten English (Opsional / Multilingual) -->
                        <div class="p-5 rounded-2xl bg-slate-50/80 border border-slate-200/90 space-y-4">
                            <div class="flex items-center gap-2 border-b border-slate-200/80 pb-3">
                                <span class="text-base">🇬🇧</span>
                                <div>
                                    <h6 class="text-sm font-satoshi-bold text-slate-900">English Content (Optional)</h6>
                                    <p class="text-[11px] text-slate-500">Property name and description translated for international guests.</p>
                                </div>
                            </div>

                            <div>
                                <x-ui.input 
                                    name="translations[en][name]" 
                                    label="Property Name (English)" 
                                    placeholder="e.g. Seminyak Sanctuary Villa" 
                                    value="{{ old('translations.en.name', $transEn->name ?? '') }}"
                                />
                            </div>

                            <div>
                                <x-ui.editor 
                                    name="translations[en][description]" 
                                    label="Property Description (English)" 
                                    placeholder="Describe property features, luxury ambiance, and location highlights in English..." 
                                    :value="old('translations.en.description', $transEn->description ?? '')"
                                />
                            </div>
                        </div>

                        <!-- Destination, Property Type & Price Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <x-ui.select2 
                                name="destination_id" 
                                label="Destinasi / Region" 
                                placeholder="Select Destination..." 
                                :options="$destinationOptions"
                                :value="old('destination_id', $property_data->destination_id ?? '')"
                            />

                            <x-ui.select2 
                                name="type" 
                                label="Property Type *" 
                                placeholder="Select Type..." 
                                :options="$propertyTypes"
                                :value="old('type', $property_data->type ?? 'Villa')"
                            />

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

                        <!-- Bedrooms, Capacity & Status Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                            <x-ui.input 
                                type="number"
                                name="bedrooms" 
                                label="Kamar Tidur (Bedrooms) *" 
                                placeholder="e.g. 3" 
                                min="1"
                                value="{{ old('bedrooms', $property_data->bedrooms ?? 1) }}"
                                required
                            />

                            <x-ui.input 
                                type="number"
                                name="capacity" 
                                label="Kapasitas Tamu (Max) *" 
                                placeholder="e.g. 6" 
                                min="1"
                                value="{{ old('capacity', $property_data->capacity ?? 2) }}"
                                required
                            />

                            <div class="flex items-center pt-6">
                                <x-ui.switch 
                                    name="status" 
                                    label="Active Status" 
                                    value="1"
                                    :checked="old('status', $property_data->status ?? true) ? true : false"
                                />
                            </div>

                            <div class="flex items-center pt-6">
                                <x-ui.switch 
                                    name="is_featured" 
                                    label="Featured Property" 
                                    value="1"
                                    :checked="old('is_featured', $property_data->is_featured ?? false) ? true : false"
                                />
                            </div>
                        </div>
                    </div>
                </x-ui.card>

                <!-- CARD: LOKASI & ALAMAT PROPERTI -->
                <x-ui.card class="p-6">
                    <div class="border-b border-slate-100 pb-4 mb-6">
                        <h5 class="text-base font-satoshi-bold text-slate-900 flex items-center gap-2">
                            <i class="ri-map-pin-line text-[#ca9e54] text-lg"></i> Lokasi &amp; Alamat Properti
                        </h5>
                        <p class="text-xs text-slate-500 mt-0.5">Wilayah administratif, kode pos, alamat jalan lengkap, serta titik koordinat &amp; peta Google Maps.</p>
                    </div>

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <x-ui.region-picker 
                                :saved-province="$savedProvince"
                                :saved-city="$savedCity"
                            />

                            <x-ui.input 
                                name="postal_code" 
                                label="Postal Code" 
                                placeholder="e.g. 80361" 
                                value="{{ old('postal_code', $property_data->postal_code ?? '') }}"
                            />
                        </div>

                        <x-ui.input 
                            name="address" 
                            label="Full Street Address" 
                            placeholder="e.g. Jl. Kayu Aya No. 88, Seminyak, Kuta, Badung Regency" 
                            value="{{ old('address', $property_data->address ?? '') }}"
                        />

                        <x-ui.map-picker 
                            :saved-map-link="$savedMapLink"
                            :saved-lat="$savedLat"
                            :saved-lng="$savedLng"
                        />
                    </div>
                </x-ui.card>

                <!-- CARD: FOTO COVER UTAMA -->
                <x-ui.card class="p-6">
                    <div class="border-b border-slate-100 pb-4 mb-6">
                        <h5 class="text-base font-satoshi-bold text-slate-900 flex items-center gap-2">
                            <i class="ri-image-2-line text-[#ca9e54] text-lg"></i> Foto Cover Utama Properti
                        </h5>
                        <p class="text-xs text-slate-500 mt-0.5">Unggah gambar resolusi tinggi untuk cover depan kartu properti.</p>
                    </div>

                    <x-ui.dropzone 
                        name="main_image" 
                        label="Main Cover Image"
                        accept="image/*"
                        :previewUrl="isset($property_data->main_image) ? asset('storage/'.$property_data->main_image) : null"
                    />
                </x-ui.card>
            </div>

            <!-- ========================================================================= -->
            <!-- TAB 2: FACILITIES & AMENITIES                                            -->
            <!-- ========================================================================= -->
            <div x-show="activeTab === 'facilities'" x-transition class="space-y-6" style="display: none;">
                <x-ui.card class="p-6">
                    <div class="border-b border-slate-100 pb-4 mb-6">
                        <h5 class="text-base font-satoshi-bold text-slate-900 flex items-center gap-2">
                            <i class="ri-building-2-line text-[#ca9e54] text-lg"></i> Fasilitas &amp; Amenitas Properti
                        </h5>
                        <p class="text-xs text-slate-500 mt-0.5">Pilih fasilitas dan kelengkapan villa yang tersedia untuk dinikmati tamu.</p>
                    </div>

                    @if($groupedFacilities->count() > 0)
                        <div class="space-y-6">
                            @foreach($groupedFacilities as $category => $items)
                                <div class="bg-slate-50/70 rounded-2xl p-5 border border-slate-200/80">
                                    <h6 class="text-xs font-satoshi-bold text-slate-800 uppercase tracking-wider mb-4 flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-[#ca9e54]"></span> {{ $category ?: 'General' }}
                                    </h6>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3.5">
                                        @foreach($items as $facility)
                                            <div class="p-3 rounded-2xl bg-white border border-slate-200/80 transition-all hover:border-slate-400 hover:shadow-xs">
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
                            Belum ada data fasilitas master. Tambahkan fasilitas di menu <a href="{{ route('facilities.index') }}" class="text-slate-900 font-satoshi-bold underline">Facilities</a> terlebih dahulu.
                        </div>
                    @endif
                </x-ui.card>
            </div>

            <!-- ========================================================================= -->
            <!-- TAB 3: SETTINGS & POLICIES                                               -->
            <!-- ========================================================================= -->
            <div x-show="activeTab === 'settings'" x-transition class="space-y-6" style="display: none;">
                <x-ui.card class="p-6">
                    <div class="border-b border-slate-100 pb-4 mb-6">
                        <h5 class="text-base font-satoshi-bold text-slate-900 flex items-center gap-2">
                            <i class="ri-customer-service-2-line text-[#ca9e54] text-lg"></i> Kontak &amp; Pengaturan Operasional
                        </h5>
                        <p class="text-xs text-slate-500 mt-0.5">Informasi kontak pemesanan langsung serta konfigurasi mata uang properti.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <x-ui.input 
                            name="phone" 
                            label="Contact Phone / WhatsApp" 
                            placeholder="e.g. +62 812 3456 7890" 
                            value="{{ old('phone', $property_data->settings->phone ?? '') }}"
                        />

                        <x-ui.input 
                            type="email"
                            name="email" 
                            label="Contact Email" 
                            placeholder="e.g. reservation@villaseminyak.com" 
                            value="{{ old('email', $property_data->settings->email ?? '') }}"
                        />

                        <x-ui.input 
                            name="currency" 
                            label="Currency Code" 
                            placeholder="e.g. IDR, USD" 
                            value="{{ old('currency', $property_data->settings->currency ?? 'IDR') }}"
                        />
                    </div>
                </x-ui.card>
            </div>

            <!-- ========================================================================= -->
            <!-- TAB 4: PHOTO GALLERY                                                     -->
            <!-- ========================================================================= -->
            <div x-show="activeTab === 'gallery'" x-transition class="space-y-6" style="display: none;">
                <x-ui.card class="p-6">
                    <div class="border-b border-slate-100 pb-4 mb-6">
                        <h5 class="text-base font-satoshi-bold text-slate-900 flex items-center gap-2">
                            <i class="ri-image-line text-[#ca9e54] text-lg"></i> Galeri Foto Properti
                        </h5>
                        <p class="text-xs text-slate-500 mt-0.5">Unggah foto-foto sudut ruangan, kolam renang, dan fasilitas villa untuk galeri foto.</p>
                    </div>

                    <div class="space-y-6">
                        <!-- Existing Gallery Photos (if editing) -->
                        @if(isset($property_data) && $property_data->galleries->count() > 0)
                            <div>
                                <h6 class="text-sm font-satoshi-bold text-slate-800 mb-3 flex items-center gap-2">
                                    <i class="ri-gallery-line text-slate-600"></i> Foto Galeri Saat Ini:
                                </h6>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                                    @foreach($property_data->galleries as $galleryItem)
                                        <div x-data="{ isDeleted: false }" 
                                             class="relative group rounded-2xl overflow-hidden border transition-all p-1.5"
                                             :class="isDeleted ? 'border-rose-300 bg-rose-50/50 opacity-60' : 'border-slate-200 bg-white shadow-xs hover:border-slate-300'">
                                            
                                            <div class="relative w-full h-28 rounded-xl overflow-hidden bg-slate-100">
                                                <img src="{{ asset('storage/' . $galleryItem->image_path) }}" class="w-full h-full object-cover">
                                                
                                                <div x-show="isDeleted" class="absolute inset-0 bg-slate-900/70 flex items-center justify-center p-2 text-center">
                                                    <span class="text-[11px] font-satoshi-bold text-white bg-rose-600 px-2 py-1 rounded-lg">Akan Dihapus</span>
                                                </div>
                                            </div>

                                            <input type="checkbox" name="delete_galleries[]" value="{{ $galleryItem->id }}" :checked="isDeleted" class="hidden">

                                            <button type="button" 
                                                    @click="isDeleted = !isDeleted" 
                                                    :title="isDeleted ? 'Batalkan Hapus' : 'Hapus Foto'"
                                                    class="absolute top-2.5 right-2.5 h-7 w-7 rounded-full bg-slate-900/80 hover:bg-rose-600 text-white flex items-center justify-center shadow-md transition-all transform hover:scale-105">
                                                <i :class="isDeleted ? 'ri-arrow-go-back-line' : 'ri-delete-bin-line'" class="text-sm"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Upload New Gallery Images using multi-image dropzone component -->
                        <div class="@if(isset($property_data) && $property_data->galleries->count() > 0) pt-4 border-t border-slate-100 @endif">
                            <x-ui.dropzone 
                                name="gallery_images[]" 
                                label="Upload Gallery Photos (Multiple Images)"
                                :multiple="true"
                                accept="image/*"
                            />
                        </div>
                    </div>
                </x-ui.card>
            </div>

            <!-- ========================================================================= -->
            <!-- GLOBAL ACTION BAR (CANCEL & SUBMIT)                                      -->
            <!-- ========================================================================= -->
            <div class="pt-4 flex items-center justify-end gap-3">
                <x-ui.button type="button" font="medium" size="sm" style="secondary" onclick="window.location.href='{{ $breadcrumb_parent?->url ?? route('properties.index') }}'">
                    Cancel
                </x-ui.button>
                <x-ui.button type="submit" font="bold" size="sm">
                    Submit
                </x-ui.button>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
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
                function generateInitialsCode(nameString) {
                    if (!nameString) return '';

                    const cleanText = nameString.trim().replace(/[^a-zA-Z0-9\s]/g, '');
                    const words = cleanText.split(/\s+/).filter(w => w.length > 0);

                    let codeResult = '';

                    if (words.length >= 3) {
                        codeResult = words[0][0] + words[1][0] + words[2][0];
                    } else if (words.length === 2) {
                        codeResult = words[0][0] + (words[1].length >= 2 ? words[1].substring(0, 2) : words[1]);
                    } else if (words.length === 1) {
                        codeResult = words[0].substring(0, 3);
                    }

                    return codeResult.toUpperCase();
                }

                nameInput.addEventListener('input', function () {
                    codeInput.value = generateInitialsCode(this.value);
                });

                if (nameInput.value && !codeInput.value) {
                    codeInput.value = generateInitialsCode(nameInput.value);
                }
            }
        });
    </script>

    {{-- SweetAlert Notification --}}
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
