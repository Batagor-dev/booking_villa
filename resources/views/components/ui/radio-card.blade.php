@props([
    'name' => '',
    'value' => '',
    'checked' => false,
    'label' => '',
    'description' => '',
    'color' => 'slate'
])

@php
    $colorMap = [
        'emerald' => [
            'checked' => 'has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/50',
            'text' => 'text-emerald-800',
            'radio' => 'text-emerald-600 focus:ring-emerald-500',
        ],
        'amber' => [
            'checked' => 'has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50/50',
            'text' => 'text-amber-800',
            'radio' => 'text-amber-600 focus:ring-amber-500',
        ],
        'rose' => [
            'checked' => 'has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50/50',
            'text' => 'text-rose-800',
            'radio' => 'text-rose-600 focus:ring-rose-500',
        ],
        'slate' => [
            'checked' => 'has-[:checked]:border-slate-800 has-[:checked]:bg-slate-50',
            'text' => 'text-slate-900',
            'radio' => 'text-slate-900 focus:ring-slate-800',
        ],
    ];

    $activeTheme = $colorMap[$color] ?? $colorMap['slate'];
@endphp

<label {{ $attributes->merge(['class' => 'p-3.5 rounded-2xl border border-slate-200 flex items-center gap-3 cursor-pointer hover:bg-slate-50 transition ' . $activeTheme['checked']]) }}>
    <input type="radio" 
           name="{{ $name }}" 
           value="{{ $value }}" 
           {{ $checked ? 'checked' : '' }} 
           class="{{ $activeTheme['radio'] }}">
    <div>
        @if($label)
            <span class="text-xs font-satoshi-bold {{ $activeTheme['text'] }} block">{{ $label }}</span>
        @endif
        @if($description)
            <span class="text-[10px] text-slate-500 block">{{ $description }}</span>
        @endif
        {{ $slot }}
    </div>
</label>
