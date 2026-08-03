@props([
    'value' => '', 
    'placeholder' => '',
    'name' => '',
    'label' => '',
    'rows' => 3
])

@php
    // Cek apakah ada error untuk textarea dengan nama ini
    $hasError = $name && $errors->has($name);

    // Atur class border dan ring secara dinamis berdasarkan status error
    $statusClasses = $hasError 
        ? 'border-red-400 bg-red-50/50 text-red-900 focus:border-red-500 focus:ring-red-100' 
        : 'border-slate-200 bg-slate-50 text-slate-900 focus:border-slate-400 focus:ring-slate-200';
    
    // Gunakan id dari attributes jika ada, jika tidak ada gunakan name sebagai fallback id
    $inputId = $attributes->get('id', $name);
@endphp

<div class="w-full">
    {{-- Label hanya akan muncul jika prop label diisi --}}
    @if($label)
        <label for="{{ $inputId }}" class="mb-2 block text-base font-satoshi-medium text-slate-700">
            {{ $label }}
        </label>
    @endif

    <textarea 
        {{ $attributes->merge([
            'id' => $inputId,
            'placeholder' => $placeholder, 
            'name' => $name,
            'rows' => $rows,
            'class' => 'block w-full font-satoshi-medium rounded-2xl border px-4 py-3 text-base outline-none transition focus:bg-white focus:ring-2 resize-y ' . $statusClasses
        ]) }}
    >{{ $value }}</textarea>

    {{-- Jika ada error, tampilkan span pesan error di bawah textarea --}}
    @if($hasError)
        <span class="mt-1.5 block text-sm font-medium text-red-600">
            {{ $errors->first($name) }}
        </span>
    @endif
</div>
