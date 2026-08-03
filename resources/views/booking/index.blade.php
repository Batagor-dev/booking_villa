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
    {{-- SweetAlert session alerts --}}
    @if(session('success'))
        <script>
            Swal.fire({ icon: 'success', title: 'Berhasil', text: "{{ session('success') }}" });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({ icon: 'error', title: 'Gagal', text: "{{ session('error') }}" });
        </script>
    @endif

    {{-- Render DataTable --}}
    {!! $dataTable->scripts() !!}

    <script>
    function updateBookingStatus(uuid, newStatus) {
        let statusLabel = newStatus === 'confirmed' ? 'menyetujui (Confirm)' : 'membatalkan (Cancel)';
        
        Swal.fire({
            title: 'Konfirmasi Perubahan Status',
            text: `Apakah Anda yakin ingin ${statusLabel} reservasi ini?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: newStatus === 'confirmed' ? '#10b981' : '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Ubah Status!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/bookings/${uuid}/status`,
                    type: 'PATCH',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: newStatus
                    },
                    success: function(res) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message });
                        window.LaravelDataTables['booking-table'].ajax.reload();
                    },
                    error: function(err) {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan saat memperbarui status.' });
                    }
                });
            }
        });
    }

    $(document).on('click', '.delete-btn', function (e) {
        e.preventDefault();
        let form = $(this).closest('form');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data booking ini akan dihapus dari sistem.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
    </script>
@endpush
