<?php

namespace App\DataTables;

use App\Models\Booking;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BookingDataTable extends DataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('booking_code', function ($row) {
                return '<span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-mono font-bold bg-slate-100 text-slate-800 border border-slate-200">' . e($row->booking_code) . '</span>';
            })
            ->addColumn('property_info', function ($row) {
                $propName = $row->property->name ?? 'Property Deleted';
                $propType = $row->property->type ?? 'Villa';
                return '<div class="space-y-0.5">
                    <div class="font-satoshi-bold text-slate-900 text-sm">' . e($propName) . '</div>
                    <span class="inline-block text-[10px] font-semibold px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200">' . e($propType) . '</span>
                </div>';
            })
            ->addColumn('guest_info', function ($row) {
                return '<div class="space-y-0.5 text-xs">
                    <div class="font-satoshi-bold text-slate-900">' . e($row->guest_name) . '</div>
                    <div class="text-slate-500 font-mono text-[11px]">' . e($row->guest_email) . '</div>
                    <div class="text-slate-500 font-mono text-[11px]">' . e($row->guest_phone ?? '-') . '</div>
                </div>';
            })
            ->addColumn('dates', function ($row) {
                $checkIn = $row->check_in ? $row->check_in->format('d M Y') : '-';
                $checkOut = $row->check_out ? $row->check_out->format('d M Y') : '-';
                $nights = $row->total_nights ?? 1;

                return '<div class="text-xs space-y-1">
                    <div class="font-satoshi-medium text-slate-800"><i class="ri-calendar-event-line text-amber-500"></i> ' . $checkIn . ' — ' . $checkOut . '</div>
                    <span class="inline-block text-[10px] px-2 py-0.5 rounded bg-slate-100 font-bold text-slate-600 border border-slate-200">' . $nights . ' Malam</span>
                </div>';
            })
            ->addColumn('total_price', function ($row) {
                return '<span class="font-satoshi-bold text-slate-900 text-sm">' . format_rupiah($row->total_price ?? 0) . '</span>';
            })
            ->addColumn('payment_info', function ($row) {
                $pmName = $row->paymentMethod->name ?? ($row->payment_type ?? 'Transfer');
                
                $receiptHtml = '';
                if ($row->bukti_payment) {
                    $src = asset('storage/' . $row->bukti_payment);
                    $receiptHtml = '<a href="' . e($src) . '" target="_blank" class="inline-flex items-center gap-1 text-[11px] text-blue-600 hover:text-blue-800 font-satoshi-medium mt-1">
                        <i class="ri-image-line"></i> Lihat Bukti Bayar
                    </a>';
                } else {
                    $receiptHtml = '<span class="text-[10px] text-slate-400 block mt-0.5">Tanpa Bukti</span>';
                }

                return '<div class="text-xs space-y-0.5">
                    <div class="font-satoshi-bold text-slate-800">' . e($pmName) . '</div>
                    ' . $receiptHtml . '
                </div>';
            })
            ->addColumn('status', function ($row) {
                $statusMap = [
                    'pending'   => ['label' => 'Pending', 'class' => 'bg-amber-50 text-amber-700 border-amber-200'],
                    'confirmed' => ['label' => 'Confirmed', 'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
                    'cancelled' => ['label' => 'Cancelled', 'class' => 'bg-rose-50 text-rose-700 border-rose-200'],
                ];
                $conf = $statusMap[$row->status] ?? $statusMap['pending'];

                return '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-satoshi-bold border ' . $conf['class'] . '">' . $conf['label'] . '</span>';
            })
            ->addColumn('action', function ($row) {
                $statusAction = '';
                if ($row->status !== 'confirmed') {
                    $statusAction .= '<button type="button" onclick="updateBookingStatus(\'' . $row->uuid . '\', \'confirmed\')" class="inline-flex items-center justify-center w-8 h-8 rounded-full text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors font-satoshi-medium" title="Confirm Booking"><i class="ri ri-checkbox-circle-line text-lg"></i></button>';
                }
                if ($row->status !== 'cancelled') {
                    $statusAction .= '<button type="button" onclick="updateBookingStatus(\'' . $row->uuid . '\', \'cancelled\')" class="inline-flex items-center justify-center w-8 h-8 rounded-full text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors font-satoshi-medium" title="Cancel Booking"><i class="ri ri-close-circle-line text-lg"></i></button>';
                }

                $editBtn = '';
                if (auth()->user()->can('Booking Update')) {
                    $editUrl = route('bookings.edit', $row->uuid);
                    $editBtn = '<a href="' . $editUrl . '" class="inline-flex items-center justify-center w-8 h-8 rounded-full text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors font-satoshi-medium" title="Edit Form Status & Data"><i class="ri ri-edit-line text-lg"></i></a>';
                }

                $deleteBtn = '';
                if (auth()->user()->can('Booking Delete')) {
                    $deleteUrl = route('bookings.destroy', $row->uuid);
                    $deleteBtn = '
                        <form action="' . $deleteUrl . '" method="POST" class="inline-block delete-booking-form m-0">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="button" class="inline-flex items-center justify-center w-8 h-8 rounded-full text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors delete-btn font-satoshi-medium" title="Delete Booking">
                                <i class="ri ri-delete-bin-line text-lg"></i>
                            </button>
                        </form>
                    ';
                }

                return '<div class="flex items-center justify-center space-x-1">' . $statusAction . $editBtn . $deleteBtn . '</div>';
            })
            ->rawColumns(['booking_code', 'property_info', 'guest_info', 'dates', 'total_price', 'payment_info', 'status', 'action']);
    }

    /**
     * Get query source of dataTable.
     */
    public function query(Booking $model)
    {
        return $model->newQuery()->with(['property', 'paymentMethod'])->latest();
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('booking-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->parameters([
                        'dom'          => '<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4"l f>rt<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-4"i p>',
                        'autoWidth'    => false,
                        'responsive'   => true,
                    ]);
    }

    /**
     * Get columns.
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false)->addClass('text-center w-12'),
            Column::make('booking_code')->title('Booking Code')->addClass('text-center'),
            Column::make('property_info')->title('Property'),
            Column::make('guest_info')->title('Guest Details'),
            Column::make('dates')->title('Stay Dates'),
            Column::make('total_price')->title('Total Price'),
            Column::make('payment_info')->title('Payment & Receipt'),
            Column::make('status')->title('Status')->addClass('text-center'),
            Column::computed('action')->title('Action')->exportable(false)->printable(false)->addClass('text-center w-28'),
        ];
    }
}
