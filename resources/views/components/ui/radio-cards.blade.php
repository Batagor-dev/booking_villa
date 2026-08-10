@props([
    'name' => '',
    'label' => '',
    'value' => '',
    'options' => [],
    'columns' => 'grid-cols-1 sm:grid-cols-3'
])

@php
    $inputId = $attributes->get('id', $name);
    $hasError = $name && $errors->has($name);
@endphp

<div class="w-full font-satoshi">
    @if($label)
        <label class="block text-sm font-satoshi-medium text-slate-700 mb-3">
            {{ $label }}
        </label>
    @endif

    <div class="grid {{ $columns }} gap-3">
        @foreach($options as $opt)
            @php
                $val = $opt['value'] ?? '';
                $optLabel = $opt['label'] ?? '';
                $optDesc = $opt['description'] ?? '';
                $color = $opt['color'] ?? 'slate';
                $isChecked = (string)$value === (string)$val;

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

            <label class="p-3.5 rounded-2xl border border-slate-200 flex items-center gap-3 cursor-pointer hover:bg-slate-50 transition {{ $activeTheme['checked'] }}">
                <input type="radio" 
                       name="{{ $name }}" 
                       value="{{ $val }}" 
                       {{ $isChecked ? 'checked' : '' }} 
                       class="{{ $activeTheme['radio'] }}">
                <div>
                    <span class="text-xs font-satoshi-bold {{ $activeTheme['text'] }} block">{{ $optLabel }}</span>
                    @if($optDesc)
                        <span class="text-[10px] text-slate-500 block">{{ $optDesc }}</span>
                    @endif
                </div>
            </label>
        @endforeach
    </div>

    @if($hasError)
        <span class="mt-1.5 block text-sm font-medium text-red-600">
            {{ $errors->first($name) }}
        </span>
    @endif
</div>
