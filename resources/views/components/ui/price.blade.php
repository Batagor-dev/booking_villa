@props([
    'value' => '',
    'name' => '',
    'label' => '',
    'placeholder' => '0',
    'type' => 'display', // 'display' or 'input'
    'prefix' => 'Rp ',
    'suffix' => '',
    'originalValue' => null,
    'class' => '',
    'originalClass' => 'text-xs text-slate-400 line-through font-mono',
    'containerClass' => 'inline-flex items-center gap-2 flex-wrap',
])

@if($type === 'input')
    @php
        // Cek apakah ada error untuk input dengan nama ini
        $hasError = $name && $errors->has($name);

        // Atur class border dan ring secara dinamis berdasarkan status error
        $statusClasses = $hasError 
            ? 'border-red-400 bg-red-50/50 text-red-900 focus:border-red-500 focus:ring-red-100' 
            : 'border-slate-200 bg-slate-50 text-slate-900 focus:border-slate-400 focus:ring-slate-200';
        
        $inputId = $attributes->get('id', $name);

        // Format the initial input value
        $formattedValue = '';
        if ($value !== null && $value !== '') {
            $numericOnly = preg_replace('/[^\d]/', '', $value);
            $formattedValue = $numericOnly !== '' ? number_format((float)$numericOnly, 0, ',', '.') : '';
        }
    @endphp

    <div class="w-full">
        @if($label)
            <label for="{{ $inputId }}" class="mb-2 block text-base font-satoshi-medium text-slate-700">
                {{ $label }}
            </label>
        @endif

        <div class="relative flex items-center">
            @if($prefix)
                <span class="absolute left-4 font-satoshi-medium text-slate-400 select-none">
                    {{ trim($prefix) }}
                </span>
            @endif
            <input 
                {{ $attributes->merge([
                    'id' => $inputId,
                    'type' => 'text', 
                    'value' => $formattedValue, 
                    'placeholder' => $placeholder, 
                    'name' => $name,
                    'class' => 'block w-full font-satoshi-medium rounded-2xl border py-3 text-base outline-none transition focus:bg-white focus:ring-2 ' . ($prefix ? 'pl-12 pr-4 ' : 'px-4 ') . $statusClasses
                ]) }}
                data-price-input="true"
            />
        </div>

        @if($hasError)
            <span class="mt-1.5 block text-sm font-medium text-red-600">
                {{ $errors->first($name) }}
            </span>
        @endif
    </div>

@else
    @php
        $formattedActive = format_rupiah($value, $prefix);
        $formattedOriginal = $originalValue ? format_rupiah($originalValue, $prefix) : null;
        $defaultClass = 'font-satoshi-bold text-slate-900';
    @endphp

    <div {{ $attributes->only('class')->merge(['class' => $containerClass]) }}>
        @if($formattedOriginal)
            <span class="{{ $originalClass }}">
                {{ $formattedOriginal }}{{ $suffix }}
            </span>
        @endif
        <span {{ $attributes->except('class')->merge(['class' => $class ?: $defaultClass]) }}>
            {{ $formattedActive }}{{ $suffix }}
        </span>
    </div>
@endif
