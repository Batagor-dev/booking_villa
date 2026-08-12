@props([
    'savedMapLink' => '',
    'savedLat' => '',
    'savedLng' => ''
])

<div class="mt-6 p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-4"
     x-data="mapEmbedHandler(@js($savedMapLink), @js($savedLat), @js($savedLng))">
    <div class="flex items-center justify-between flex-wrap gap-2">
        <label class="text-base font-satoshi-medium text-slate-800 flex items-center gap-2">
            <i class="ri-map-pin-2-fill text-rose-500 text-lg"></i> Google Maps Embed (Tag &lt;iframe&gt;)
        </label>

        <a href="https://www.google.com/maps" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-satoshi-medium text-slate-700 hover:text-slate-950">
            <i class="ri-external-link-line"></i> Buka Google Maps (Share -&gt; Embed a map)
        </a>
    </div>

    <!-- Hidden inputs for Latitude & Longitude automatically extracted from iframe -->
    <input type="hidden" name="latitude" :value="extractedCoords ? extractedCoords.lat : initialLat">
    <input type="hidden" name="longitude" :value="extractedCoords ? extractedCoords.lng : initialLng">

    <div>
        <div class="flex items-center justify-between gap-2 mb-2 flex-wrap">
            <label class="block text-xs font-satoshi-medium text-slate-700">
                Kode Embed Google Maps (Wajib Tag <code class="text-rose-600 bg-rose-50 px-1 py-0.5 rounded">&lt;iframe&gt;...&lt;/iframe&gt;</code>):
            </label>
            <button type="button" @click="generatePinEmbedFromAddress()" class="inline-flex items-center gap-1.5 text-xs font-satoshi-bold text-slate-700 hover:text-rose-600 bg-white hover:bg-rose-50 border border-slate-200 hover:border-rose-200 px-3 py-1.5 rounded-xl transition-all shadow-2xs cursor-pointer">
                <i class="ri-map-pin-2-fill text-rose-500"></i> Buat Pin Titik Otomatis dari Alamat
            </button>
        </div>
        <textarea 
            name="map_link" 
            x-model="rawMapLink"
            rows="3" 
            class="w-full rounded-2xl border bg-white px-4 py-3 text-sm font-mono text-slate-900 focus:outline-none transition placeholder:text-slate-400"
            :class="isInvalidFormat ? 'border-rose-400 focus:border-rose-500 focus:ring-2 focus:ring-rose-200' : 'border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200'"
            placeholder="Paste kode HTML <iframe>...</iframe> dari Google Maps di sini (Buka Maps -> Share -> Embed a map)"
        ></textarea>
        
        <template x-if="isInvalidFormat">
            <div class="mt-2 flex items-center gap-1.5 text-xs text-rose-600 font-satoshi-medium">
                <i class="ri-error-warning-fill"></i>
                <span>Format tidak valid! Hanya menerima kode Embed Tag <code>&lt;iframe&gt;</code> dari Google Maps. Link biasa (seperti https://maps.app.goo.gl/...) tidak bisa digunakan.</span>
            </div>
        </template>

        <span x-show="!isInvalidFormat" class="text-[11px] text-slate-500 mt-1.5 block">
            💡 <strong>Wajib Tag Iframe:</strong> Salin kode HTML <code>&lt;iframe&gt;</code> dari Google Maps (pilih <strong>Bagikan / Share</strong> &rarr; <strong>Sematkan Peta / Embed a map</strong>). Link biasa tidak didukung.
        </span>
    </div>

    <!-- Live Preview Iframe Map Display -->
    <div x-show="embedUrl && !isInvalidFormat" x-transition class="pt-2">
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

@once
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('mapEmbedHandler', (initialLink, initialLat, initialLng) => ({
            rawMapLink: initialLink || '',
            initialLat: initialLat || '',
            initialLng: initialLng || '',
            extractedCoords: null,
            embedUrl: '',
            isInvalidFormat: false,

            init() {
                this.processInput(this.rawMapLink);
                this.$watch('rawMapLink', (val) => {
                    this.processInput(val);
                });
            },

            processInput(text) {
                if (!text || !text.trim()) {
                    this.embedUrl = '';
                    this.isInvalidFormat = false;
                    this.extractedCoords = null;
                    return;
                }

                const trimmed = text.trim();
                const iframeMatch = trimmed.match(/src=["']([^"']+)["']/i);

                if (trimmed.includes('<iframe') && iframeMatch && iframeMatch[1]) {
                    this.isInvalidFormat = false;
                    this.embedUrl = iframeMatch[1];
                    this.extractCoords(trimmed);
                } else {
                    this.isInvalidFormat = true;
                    this.embedUrl = '';
                    this.extractedCoords = null;
                }
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

            extractCoords(text) {
                if (!text) {
                    this.extractedCoords = null;
                    return;
                }
                const latMatch = text.match(/!3d(-?\d+\.\d+)/);
                const lngMatch = text.match(/!4d(-?\d+\.\d+)/) || text.match(/!2d(-?\d+\.\d+)/);
                
                let lat = null;
                let lng = null;
                
                if (latMatch && lngMatch) {
                    lat = latMatch[1];
                    lng = lngMatch[1];
                } else {
                    const altMatch = text.match(/[@?&]q?=?(-?\d+\.\d+),(-?\d+\.\d+)/);
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
@endonce
