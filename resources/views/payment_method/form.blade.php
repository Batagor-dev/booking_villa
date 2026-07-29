@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Payment Methods';

    if (isset($payment_method_data)) {
        $breadcrumbsData = Breadcrumbs::generate(Request::route()->getName(), $payment_method_data);
    } else {
        $breadcrumbsData = Breadcrumbs::generate(Request::route()->getName());
    }
    $breadcrumb_parent = $breadcrumbsData->where('title', '!=', $breadcrumb->title)->last();

    $paymentTypes = [
        ['value' => 'cash', 'label' => 'Cash (Tunai)'],
        ['value' => 'bank_transfer', 'label' => 'Bank Transfer'],
        ['value' => 'qris', 'label' => 'QRIS'],
        ['value' => 'credit_card', 'label' => 'Credit Card'],
        ['value' => 'debit_card', 'label' => 'Debit Card'],
        ['value' => 'ewallet', 'label' => 'E-Wallet'],
        ['value' => 'other', 'label' => 'Other'],
    ];
@endphp

@extends('layouts.backend.main')

@section('title', 'Payment Method Form')
@section('sub_title', $sub_title)

@section('breadcrumb')
    <x-layout.admin.breadcrumb :breadcrumbs="$breadcrumbsData" />
@endsection

@section('content')
    <div class="space-y-6 pb-12">
        <x-ui.card>
            <form method="POST" action="{{ $action }}" class="space-y-6" enctype="multipart/form-data"
                  x-data="{ currentType: '{{ old('type', $payment_method_data->type ?? 'bank_transfer') }}' }"
                  @change="if ($event.target.name === 'type') currentType = $event.target.value">
                @isset($payment_method_data) @method('PUT') @endisset
                @csrf

                <h5 class="text-lg font-satoshi-bold text-slate-900 mb-6">{{ $sub_title }}</h5>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Method Name -->
                    <x-ui.input 
                        name="name" 
                        label="Payment Method Name *" 
                        placeholder="e.g. Transfer Bank BCA, QRIS Standar, Cash / Tunai" 
                        value="{{ old('name', $payment_method_data->name ?? '') }}"
                        required
                    />

                    <!-- Type -->
                    <div>
                        <x-ui.select2 
                            name="type" 
                            label="Payment Type *" 
                            placeholder="Select Payment Type..." 
                            :options="$paymentTypes"
                            :value="old('type', $payment_method_data->type ?? 'bank_transfer')"
                        />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Provider -->
                    <x-ui.input 
                        name="provider" 
                        label="Provider / Bank Name" 
                        placeholder="e.g. BCA, Mandiri, Midtrans, OVO, GoPay" 
                        value="{{ old('provider', $payment_method_data->provider ?? '') }}"
                    />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Account Number -->
                    <x-ui.input 
                        name="account_number" 
                        label="Account Number / No. Rekening" 
                        placeholder="e.g. 1234567890" 
                        value="{{ old('account_number', $payment_method_data->account_number ?? '') }}"
                    />

                    <!-- Account Name -->
                    <x-ui.input 
                        name="account_name" 
                        label="Account Name / Atas Nama" 
                        placeholder="e.g. PT Villa Indonesia" 
                        value="{{ old('account_name', $payment_method_data->account_name ?? '') }}"
                    />
                </div>

                <!-- Status / Active -->
                <div class="flex items-center pt-2">
                    <x-ui.switch 
                        name="is_active" 
                        label="Active" 
                        value="1"
                        :checked="old('is_active', $payment_method_data->is_active ?? true) ? true : false"
                    />
                </div>

                <!-- Note / Payment Instructions -->
                <div>
                    <label class="mb-2 block text-base font-satoshi-medium text-slate-700">Payment Instructions / Note</label>
                    <textarea name="note" rows="3" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-satoshi-medium text-slate-700 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" placeholder="Informasi atau petunjuk pembayaran bagi tamu...">{{ old('note', $payment_method_data->note ?? '') }}</textarea>
                </div>

                <!-- Images: Provider Logo & QRIS Image -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="mb-2 block text-base font-satoshi-medium text-slate-700">Provider Logo (Optional)</label>
                        <x-ui.dropzone 
                            name="logo_provider" 
                            accept="image/*"
                            :previewUrl="isset($payment_method_data->logo_provider) ? asset('storage/'.$payment_method_data->logo_provider) : null"
                        />
                    </div>

                    <div x-show="currentType === 'qris'" x-transition>
                        <label class="mb-2 block text-base font-satoshi-medium text-slate-700">QRIS Barcode Image (Optional)</label>
                        <x-ui.dropzone 
                            name="image_qris" 
                            accept="image/*"
                            :previewUrl="isset($payment_method_data->image_qris) ? asset('storage/'.$payment_method_data->image_qris) : null"
                        />
                    </div>
                </div>

                <!-- Submit / Cancel -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <x-ui.button type="button" font="medium" size="sm" style="secondary" onclick="window.location.href='{{ $breadcrumb_parent?->url ?? route('payment_methods.index') }}'">
                        Cancel
                    </x-ui.button>
                    <x-ui.button type="submit" font="bold" size="sm">
                        Submit
                    </x-ui.button>
                </div>
            </form>
        </x-ui.card>
    </div>
@endsection

@push('scripts')
    {{-- SweetAlert notifications --}}
    @if(session('success'))
        <script>
            Swal.fire({ icon: 'success', title: 'Success', text: "{{ session('success') }}" });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({ icon: 'error', title: 'Error', text: "{{ session('error') }}" });
        </script>
    @endif
@endpush
