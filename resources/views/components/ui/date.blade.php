@props([
    'name' => '',
    'checkinName' => 'check_in',
    'checkoutName' => 'check_out',
    'label' => '',
    'checkinLabel' => 'CHECK IN',
    'checkoutLabel' => 'CHECK OUT',
    'placeholder' => 'Pilih tanggal...',
    'checkinPlaceholder' => 'Tanggal Check-in',
    'checkoutPlaceholder' => 'Tanggal Check-out',
    'value' => '',
    'checkinValue' => '',
    'checkoutValue' => '',
    'type' => 'date', // date, time, datetime, multiple, range
    'humanFriendly' => true,
    'disabledDates' => [], // e.g. [['from' => '2026-08-05', 'to' => '2026-08-10']] or ['2026-08-05']
    'inline' => false,
    'showMonths' => null, // null (auto 2 for range), 1, or 2
    'minDate' => 'today',
    'maxDate' => null,
])

@php
    $isRange = ($type === 'range') || (!empty($checkinName) && !empty($checkoutName) && empty($name));
    $numMonths = $showMonths ?? ($isRange ? 2 : 1);
    
    $hasError = ($name && $errors->has($name)) || ($checkinName && $errors->has($checkinName)) || ($checkoutName && $errors->has($checkoutName));
    $statusClasses = $hasError 
        ? 'border-red-400 bg-red-50/50 text-red-900 focus:border-red-500 focus:ring-red-100' 
        : 'border-slate-200 bg-white text-slate-900 focus:border-[#152c4e] focus:ring-slate-200';
    
    $inputId = $attributes->get('id', $isRange ? 'range_date_picker_' . uniqid() : ($name ?: 'date_picker_' . uniqid()));
@endphp

@once
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <style>
            /* Modern Luxury Flatpickr Styling (Matching Navy #152c4e & Gold #ca9e54 Palette) */
            .flatpickr-calendar {
                border-radius: 1.5rem !important;
                border: 1px solid #e2e8f0 !important;
                box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.12), 0 10px 15px -3px rgba(15, 23, 42, 0.04) !important;
                font-family: 'Satoshi', sans-serif !important;
                background: #ffffff !important;
                padding: 1rem !important;
                width: 100% !important;
                max-width: 330px !important;
                margin: 0 auto !important;
            }

            .flatpickr-calendar.multiMonth {
                max-width: 660px !important;
            }

            .flatpickr-calendar.inline {
                box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.05) !important;
                width: 100% !important;
            }

            .flatpickr-innerContainer {
                display: flex !important;
                flex-wrap: wrap !important;
                justify-content: center !important;
                gap: 1.25rem !important;
            }

            /* Month Header Bar & Controls */
            .flatpickr-months {
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                padding: 0.25rem 0.5rem 0.75rem 0.5rem !important;
                position: relative !important;
            }

            .flatpickr-months .flatpickr-month {
                flex: 1 !important;
                text-align: center !important;
                height: auto !important;
                background: transparent !important;
                color: #152c4e !important;
            }

            .flatpickr-current-month {
                position: static !important;
                width: auto !important;
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 0.35rem !important;
                font-size: 0.95rem !important;
                font-weight: 700 !important;
                color: #152c4e !important;
                padding: 0 !important;
                letter-spacing: -0.01em;
            }

            .flatpickr-current-month .flatpickr-monthDropdown-months,
            .flatpickr-current-month .numInputWrapper input.numInput {
                font-family: 'Satoshi', sans-serif !important;
                font-weight: 700 !important;
                color: #152c4e !important;
                appearance: none !important;
                -webkit-appearance: none !important;
                border: none !important;
                background: transparent !important;
                font-size: 0.95rem !important;
                padding: 0 !important;
                margin: 0 !important;
                pointer-events: none !important;
            }

            .flatpickr-current-month .numInputWrapper span {
                display: none !important;
            }

            /* Nav Arrows (< and >) */
            .flatpickr-prev-month, .flatpickr-next-month {
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 2.25rem !important;
                height: 2.25rem !important;
                border-radius: 9999px !important;
                background-color: #f8fafc !important;
                border: 1px solid #e2e8f0 !important;
                color: #475569 !important;
                transition: all 0.2s ease !important;
                cursor: pointer !important;
                z-index: 5 !important;
                padding: 0 !important;
            }

            .flatpickr-prev-month:hover, .flatpickr-next-month:hover {
                background-color: #152c4e !important;
                color: #ffffff !important;
                border-color: #152c4e !important;
            }

            .flatpickr-prev-month svg, .flatpickr-next-month svg {
                width: 0.85rem !important;
                height: 0.85rem !important;
                fill: currentColor !important;
            }

            /* Weekday Bar */
            .flatpickr-weekdays {
                padding: 0.5rem 0 !important;
                height: auto !important;
                display: flex !important;
                border-bottom: 1px dashed #f1f5f9 !important;
                margin-bottom: 0.5rem !important;
                width: 100% !important;
            }

            .flatpickr-weekdaycontainer {
                flex: 1 !important;
                display: flex !important;
                justify-content: space-around !important;
                width: 100% !important;
                max-width: 280px !important;
                margin: 0 auto !important;
            }

            span.flatpickr-weekday {
                color: #94a3b8 !important;
                font-weight: 700 !important;
                font-size: 0.725rem !important;
                text-transform: uppercase !important;
                letter-spacing: 0.03em !important;
                font-family: 'Satoshi', sans-serif !important;
                flex: 1 !important;
                text-align: center !important;
                max-width: 38px !important;
            }

            /* Day Grid */
            .flatpickr-days {
                padding: 0 !important;
                width: 100% !important;
                display: flex !important;
                justify-content: center !important;
            }

            .dayContainer {
                width: 280px !important;
                min-width: 280px !important;
                max-width: 280px !important;
                gap: 2px 0 !important;
                display: flex !important;
                flex-wrap: wrap !important;
                justify-content: flex-start !important;
            }

            .flatpickr-day {
                background: transparent !important;
                border-radius: 9999px !important;
                font-family: 'Satoshi', sans-serif !important;
                font-weight: 600 !important;
                font-size: 0.85rem !important;
                color: #1e293b !important;
                border: 1px solid transparent !important;
                height: 38px !important;
                line-height: 38px !important;
                width: 38px !important;
                max-width: 38px !important;
                flex-basis: 38px !important;
                margin: 0 !important;
                box-shadow: none !important;
                transition: background-color 0.15s ease, color 0.15s ease !important;
            }

            .flatpickr-day.prevMonthDay, .flatpickr-day.nextMonthDay {
                color: #cbd5e1 !important;
                opacity: 0.3 !important;
                background: transparent !important;
            }

            .flatpickr-day:hover, .flatpickr-day:focus {
                background-color: #f1f5f9 !important;
                color: #152c4e !important;
                border-color: transparent !important;
            }

            /* Today Date Style - Same as normal dates */
            .flatpickr-day.today {
                border-color: transparent !important;
                background-color: transparent !important;
                color: #1e293b !important;
                font-weight: 600 !important;
            }

            .flatpickr-day.today::after {
                display: none !important;
            }

            /* Selected Range Styling (Deep Navy & Soft Navy Tint) */
            .flatpickr-day.selected,
            .flatpickr-day.startRange,
            .flatpickr-day.endRange {
                background: #152c4e !important;
                color: #ffffff !important;
                font-weight: 700 !important;
                border-color: #152c4e !important;
                box-shadow: 0 4px 12px rgba(21, 44, 78, 0.25) !important;
            }

            .flatpickr-day.startRange {
                border-radius: 9999px 0 0 9999px !important;
            }

            .flatpickr-day.endRange {
                border-radius: 0 9999px 9999px 0 !important;
            }

            .flatpickr-day.startRange.endRange {
                border-radius: 9999px !important;
            }

            /* Days inside selected range - Continuous Soft Navy Tint Ribbon */
            .flatpickr-day.inRange {
                background: #eef2ff !important;
                color: #152c4e !important;
                font-weight: 700 !important;
                border-radius: 0 !important;
                border-color: transparent !important;
                box-shadow: -2px 0 0 #eef2ff, 2px 0 0 #eef2ff !important;
            }

            .flatpickr-day.inRange:hover {
                background: #e0e7ff !important;
                box-shadow: -2px 0 0 #e0e7ff, 2px 0 0 #e0e7ff !important;
            }

            /* Booked / Disabled Dates Styling */
            .flatpickr-day.flatpickr-disabled,
            .flatpickr-day.flatpickr-disabled:hover {
                background-color: transparent !important;
                color: #cbd5e1 !important;
                text-decoration: line-through !important;
                cursor: not-allowed !important;
                opacity: 0.4 !important;
                border-color: transparent !important;
                box-shadow: none !important;
            }
        </style>
    @endpush
@endonce

<div class="w-full text-left font-satoshi" 
     x-data="{
        checkin: '{{ $checkinValue }}',
        checkout: '{{ $checkoutValue }}',
        singleValue: '{{ $value }}',
        nights: 0,
        fp: null,
        activeField: 'checkin',
        
        calculateNights() {
            if (this.checkin && this.checkout) {
                const d1 = new Date(this.checkin);
                const d2 = new Date(this.checkout);
                const diff = Math.round((d2 - d1) / (1000 * 60 * 60 * 24));
                this.nights = diff > 0 ? diff : 0;
            } else {
                this.nights = 0;
            }
        },

        formatDateIndo(dateStr) {
            if (!dateStr) return '';
            const parts = dateStr.split('-');
            if (parts.length !== 3) return dateStr;
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            const day = parseInt(parts[2], 10);
            const monthIdx = parseInt(parts[1], 10) - 1;
            const year = parts[0];
            const dateObj = new Date(year, monthIdx, day);
            const days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
            const dayName = days[dateObj.getDay()];
            return `${dayName}, ${day} ${months[monthIdx]} ${year}`;
        },

        init() {
            this.calculateNights();

            const indonesianL10n = {
                firstDayOfWeek: 1,
                weekdays: {
                    shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                    longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
                },
                months: {
                    shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
                }
            };

            const isRangeMode = {{ $isRange ? 'true' : 'false' }};
            const desiredMonths = {{ $numMonths }};
            const responsiveMonths = (window.innerWidth < 768) ? 1 : desiredMonths;
            
            let options = {
                allowInput: true,
                dateFormat: 'Y-m-d',
                locale: indonesianL10n,
                mode: isRangeMode ? 'range' : '{{ in_array($type, ['multiple', 'range']) ? $type : 'single' }}',
                showMonths: responsiveMonths,
                inline: {{ $inline ? 'true' : 'false' }},
                position: 'auto',
            };

            @if(!empty($disabledDates))
                options.disable = {!! json_encode($disabledDates) !!};
            @endif

            @if($minDate)
                options.minDate = '{{ $minDate }}';
            @endif

            @if($maxDate)
                options.maxDate = '{{ $maxDate }}';
            @endif

            if (isRangeMode) {
                let defaultDates = [];
                if (this.checkin) defaultDates.push(this.checkin);
                if (this.checkout) defaultDates.push(this.checkout);
                if (defaultDates.length > 0) {
                    options.defaultDate = defaultDates;
                }

                options.onChange = (selectedDates, dateStr, instance) => {
                    if (selectedDates.length >= 1) {
                        this.checkin = instance.formatDate(selectedDates[0], 'Y-m-d');
                    } else {
                        this.checkin = '';
                    }

                    if (selectedDates.length >= 2) {
                        this.checkout = instance.formatDate(selectedDates[1], 'Y-m-d');
                    } else {
                        this.checkout = '';
                    }

                    this.calculateNights();

                    // Dispatch custom event & trigger calculateBookingTotal if available on window
                    $dispatch('date-range-selected', { checkin: this.checkin, checkout: this.checkout, nights: this.nights });
                    
                    if (typeof window.calculateBookingTotal === 'function') {
                        window.calculateBookingTotal();
                    }
                };
            }

            this.fp = flatpickr(this.$refs.dateInput, options);
        }
     }">

    @if($isRange)
        <!-- DUAL CHECK-IN & CHECK-OUT CARDS IN ONE COMPONENT -->
        @if($label)
            <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700">
                {{ $label }}
            </label>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
            <!-- CHECK-IN CARD -->
            <div class="p-3.5 rounded-2xl bg-white border border-slate-200 hover:border-[#ca9e54] transition-all cursor-pointer shadow-sm hover:shadow-md group"
                 :class="{'border-[#152c4e] ring-2 ring-[#152c4e]/10 bg-slate-50/50': activeField === 'checkin'}"
                 @click="activeField = 'checkin'; fp && fp.open()">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-[10px] font-extrabold tracking-wider text-slate-400 uppercase">
                        {{ $checkinLabel }}
                    </span>
                    <i class="ri-calendar-check-line text-base text-[#ca9e54] group-hover:scale-110 transition-transform"></i>
                </div>
                <div class="text-sm font-bold text-slate-900" x-text="formatDateIndo(checkin) || '{{ $checkinPlaceholder }}'"></div>
                <input type="hidden" name="{{ $checkinName }}" id="input-check-in" x-model="checkin">
            </div>

            <!-- CHECK-OUT CARD -->
            <div class="p-3.5 rounded-2xl bg-white border border-slate-200 hover:border-[#ca9e54] transition-all cursor-pointer shadow-sm hover:shadow-md group"
                 :class="{'border-[#152c4e] ring-2 ring-[#152c4e]/10 bg-slate-50/50': activeField === 'checkout'}"
                 @click="activeField = 'checkout'; fp && fp.open()">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-[10px] font-extrabold tracking-wider text-slate-400 uppercase">
                        {{ $checkoutLabel }}
                    </span>
                    <div class="flex items-center gap-1.5">
                        <template x-if="nights > 0">
                            <span class="text-[10px] font-extrabold px-2 py-0.5 rounded-full bg-[#152c4e] text-white shadow-xs" x-text="nights + ' Malam'"></span>
                        </template>
                        <i class="ri-calendar-event-line text-base text-rose-500 group-hover:scale-110 transition-transform"></i>
                    </div>
                </div>
                <div class="text-sm font-bold text-slate-900" x-text="formatDateIndo(checkout) || '{{ $checkoutPlaceholder }}'"></div>
                <input type="hidden" name="{{ $checkoutName }}" id="input-check-out" x-model="checkout">
            </div>
        </div>

        <!-- Hidden Flatpickr Trigger Target & Wrapper -->
        <div class="flex justify-center w-full overflow-x-auto py-1">
            <input type="text" class="sr-only opacity-0 h-0 w-0 pointer-events-none" x-ref="dateInput">
        </div>

    @else
        <!-- SINGLE DATE INPUT FIELD -->
        @if($label)
            <label for="{{ $inputId }}" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700">
                {{ $label }}
            </label>
        @endif

        <div class="relative">
            <input 
                {{ $attributes->merge([
                    'id' => $inputId,
                    'name' => $name,
                    'value' => $value,
                    'placeholder' => $placeholder,
                    'class' => 'block w-full font-satoshi-medium rounded-2xl border px-4 py-3.5 text-sm outline-none transition focus:bg-white focus:ring-2 ' . $statusClasses
                ]) }} 
                x-ref="dateInput"
            />
            
            @if(!$inline && $type !== 'time')
                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                    <i class="ri-calendar-line text-lg"></i>
                </div>
            @elseif(!$inline && $type === 'time')
                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                    <i class="ri-time-line text-lg"></i>
                </div>
            @endif
        </div>
    @endif

    @if($hasError)
        <span class="mt-1.5 block text-xs font-semibold text-red-600">
            {{ $errors->first($name ?: $checkinName) }}
        </span>
    @endif
</div>

@once
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @endpush
@endonce
