@props([
    'name',
    'id' => null,
    'label' => '',
    'checked' => false,
    'value' => '1',
])

@php
    $switchId = $id ?? $name;
@endphp

<div class="flex flex-col gap-2">
    @if($label)
        <label for="{{ $switchId }}" class="cursor-pointer select-none text-base font-satoshi-medium text-slate-700 transition hover:text-black">
            {{ $label }}
        </label>
    @endif

    <div class="relative inline-flex items-center">
        <!-- Hidden input that actually handles the value -->
        <input 
            type="checkbox" 
            id="{{ $switchId }}" 
            name="{{ $name }}" 
            value="{{ $value }}"
            {{ $checked ? 'checked' : '' }}
            {{ $attributes->merge([
                'class' => 'peer sr-only'
            ]) }}
        />
        
        <!-- Toggle track -->
        <label for="{{ $switchId }}" class="relative h-6 w-11 cursor-pointer rounded-full bg-slate-200 transition-colors duration-200 after:absolute after:start-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-slate-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-slate-900 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-slate-400 peer-focus:ring-offset-2"></label>
    </div>
</div>
