@props([
    'name',
    'id' => null,
    'label' => '',
    'checked' => false,
    'reverse' => false,
    'size' => 'sm',
])

@php
    $checkboxId = $id ?? $name;
    $labelSizeClass = $size === 'xs' ? 'text-xs' : ($size === 'base' ? 'text-base' : 'text-sm');
@endphp

<div class="flex items-center gap-2">
    {{-- Label di samping kiri checkbox jika reverse --}}
    @if($reverse && $label)
        <label for="{{ $checkboxId }}" class="cursor-pointer select-none {{ $labelSizeClass }} font-satoshi-medium text-slate-700 transition hover:text-slate-900">
            {{ $label }}
        </label>
    @endif

    <div class="relative flex items-center">
        <input 
            type="checkbox" 
            id="{{ $checkboxId }}" 
            name="{{ $name }}" 
            {{ $checked ? 'checked' : '' }}
            {{ $attributes->merge([
                'class' => 'peer h-4.5 w-4.5 cursor-pointer appearance-none rounded-md border border-slate-300 bg-white transition-all duration-200 checked:border-[#152c4e] checked:bg-[#152c4e] focus:outline-none focus:ring-2 focus:ring-[#ca9e54]/30'
            ]) }}
        />
        
        <!-- Icon Centang SVG dengan Efek Animasi Transisi -->
        <span class="pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 scale-50 text-white opacity-0 transition-all duration-200 peer-checked:scale-100 peer-checked:opacity-100">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </span>
    </div>

    {{-- Label di samping kanan checkbox jika tidak reverse --}}
    @if(!$reverse && $label)
        <label for="{{ $checkboxId }}" class="cursor-pointer select-none {{ $labelSizeClass }} font-satoshi-medium text-slate-700 transition hover:text-slate-900">
            {{ $label }}
        </label>
    @endif
</div>