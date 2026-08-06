@props([
    'savedMapLink' => '',
    'savedLat' => '',
    'savedLng' => ''
])

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

@once
<script>
    document.addEventListener('alpine:init', () => {
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
@endonce
