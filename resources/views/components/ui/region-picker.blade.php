@props([
    'savedProvince' => '',
    'savedCity' => ''
])

<div style="display: contents;" x-data="regionPicker({
    initialProvince: @js($savedProvince),
    initialCity: @js($savedCity)
})">
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
</div>

@once
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

            toTitleCase(str) {
                if (!str) return '';
                return str.toLowerCase().replace(/(?:^|\s|-)\S/g, (m) => m.toUpperCase());
            },

            async init() {
                await this.fetchProvinces();
                if (this.selectedProvince) {
                    const foundProv = this.provinces.find(p => p.name.toUpperCase() === this.selectedProvince.toUpperCase());
                    if (foundProv) {
                        this.selectedProvince = foundProv.name;
                        await this.fetchRegencies(foundProv.id);
                        if (this.selectedCity) {
                            const foundCity = this.regencies.find(r => r.name.toUpperCase() === this.selectedCity.toUpperCase());
                            if (foundCity) {
                                this.selectedCity = foundCity.name;
                            }
                        }
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
                    this.provinces = (data || []).map(p => ({
                        id: p.id,
                        name: this.toTitleCase(p.name)
                    })).sort((a, b) => a.name.localeCompare(b.name));
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
                    this.regencies = (data || []).map(r => ({
                        id: r.id,
                        name: this.toTitleCase(r.name)
                    })).sort((a, b) => a.name.localeCompare(b.name));
                } catch (e) {
                    console.error('Error fetching regencies:', e);
                } finally {
                    this.loadingRegencies = false;
                }
            }
        }));
    });
</script>
@endonce
