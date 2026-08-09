@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Bookings';
    $breadcrumbsData = Breadcrumbs::generate(Request::route()->getName());
@endphp

@extends('layouts.backend.main')

@section('title', 'Bookings')
@section('sub_title', $sub_title)

@section('breadcrumb')
    <x-layout.admin.breadcrumb :breadcrumbs="$breadcrumbsData" />
@endsection

@section('content')
<div class="space-y-8 pb-12">
    <x-ui.card>
        <div class="flex items-center justify-between mb-4">
            <div>
                <h5 class="text-lg font-satoshi-bold text-slate-900 mb-0">Booking Management</h5>
                <p class="text-xs text-slate-500 font-satoshi-medium">Daftar transaksi dan verifikasi reservasi villa dari tamu.</p>
            </div>
        </div>

        <div>
            {!! $dataTable->table(['width' => '100%']) !!}
        </div>
    </x-ui.card>
</div>
@endsection

@push('scripts')
    {{-- Render DataTable --}}
    {!! $dataTable->scripts() !!}

    <script>
    function updateBookingStatus(uuid, newStatus) {
        let isConfirm = newStatus === 'confirmed';
        let statusLabel = isConfirm ? 'menyetujui (Confirm)' : 'membatalkan (Cancel)';
        
        openConfirmModal({
            title: 'Konfirmasi Perubahan Status',
            message: `Apakah Anda yakin ingin ${statusLabel} reservasi ini?`,
            variant: isConfirm ? 'success' : 'danger',
            confirmText: isConfirm ? 'Ya, Setujui' : 'Ya, Batalkan',
            icon: isConfirm ? 'ri-checkbox-circle-line text-2xl' : 'ri-close-circle-line text-2xl',
            onConfirm: function() {
                $.ajax({
                    url: `/bookings/${uuid}/status`,
                    type: 'PATCH',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: newStatus
                    },
                    success: function(res) {
                        if (typeof createToast === 'function') {
                            createToast('success', res.message || 'Status reservasi berhasil diperbarui.');
                        }
                        if (window.LaravelDataTables && window.LaravelDataTables['booking-table']) {
                            window.LaravelDataTables['booking-table'].ajax.reload();
                        } else {
                            location.reload();
                        }
                    },
                    error: function(err) {
                        let errMsg = (err.responseJSON && err.responseJSON.message) ? err.responseJSON.message : 'Terjadi kesalahan saat memperbarui status.';
                        if (typeof createToast === 'function') {
                            createToast('danger', errMsg);
                        } else {
                            alert(errMsg);
                        }
                    }
                });
            }
        });
    }
    </script>
@endpush
