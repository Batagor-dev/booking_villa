<?php

namespace App\DataTables;

use App\Models\PaymentMethod;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PaymentMethodDataTable extends DataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('logo_display', function ($row) {
                if ($row->logo_provider) {
                    return '<img src="' . asset('storage/' . $row->logo_provider) . '" class="w-10 h-10 object-contain rounded-lg shadow-xs mx-auto border border-slate-200 p-1 bg-white">';
                }
                return '<div class="w-10 h-10 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-xl"><i class="ri-bank-card-line"></i></div>';
            })
            ->addColumn('type_badge', function ($row) {
                $badges = [
                    'cash'          => '<span class="inline-flex items-center rounded-md bg-emerald-50 px-2.5 py-1 text-xs font-satoshi-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Cash</span>',
                    'bank_transfer' => '<span class="inline-flex items-center rounded-md bg-blue-50 px-2.5 py-1 text-xs font-satoshi-medium text-blue-700 ring-1 ring-inset ring-blue-600/20">Bank Transfer</span>',
                    'qris'          => '<span class="inline-flex items-center rounded-md bg-purple-50 px-2.5 py-1 text-xs font-satoshi-medium text-purple-700 ring-1 ring-inset ring-purple-600/20">QRIS</span>',
                    'credit_card'   => '<span class="inline-flex items-center rounded-md bg-amber-50 px-2.5 py-1 text-xs font-satoshi-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">Credit Card</span>',
                    'debit_card'    => '<span class="inline-flex items-center rounded-md bg-cyan-50 px-2.5 py-1 text-xs font-satoshi-medium text-cyan-700 ring-1 ring-inset ring-cyan-600/20">Debit Card</span>',
                    'ewallet'       => '<span class="inline-flex items-center rounded-md bg-indigo-50 px-2.5 py-1 text-xs font-satoshi-medium text-indigo-700 ring-1 ring-inset ring-indigo-600/20">E-Wallet</span>',
                    'other'         => '<span class="inline-flex items-center rounded-md bg-slate-100 px-2.5 py-1 text-xs font-satoshi-medium text-slate-700">Other</span>',
                ];
                return $badges[$row->type] ?? '<span class="inline-flex items-center rounded-md bg-slate-100 px-2.5 py-1 text-xs font-satoshi-medium text-slate-700">' . e($row->type) . '</span>';
            })
            ->addColumn('account_info', function ($row) {
                if ($row->account_number || $row->account_name) {
                    $accNum = $row->account_number ? e($row->account_number) : '-';
                    $accName = $row->account_name ? 'a.n. ' . e($row->account_name) : '';
                    return '<div class="text-xs font-satoshi-medium text-slate-900">' . $accNum . '</div>' .
                           ($accName ? '<div class="text-xs text-slate-500 font-satoshi-regular">' . $accName . '</div>' : '');
                }
                return '<span class="text-slate-400 text-xs">-</span>';
            })
            ->addColumn('status', function ($row) {
                return $row->is_active
                    ? '<span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-satoshi-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/10"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active</span>'
                    : '<span class="inline-flex items-center gap-1 rounded-full bg-rose-50 px-2.5 py-1 text-xs font-satoshi-medium text-rose-700 ring-1 ring-inset ring-rose-600/10"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Inactive</span>';
            })
            ->addColumn('action', function ($row) {
                $user = auth()->user();
                $canEdit = !$user || $user->can('Payment Method Update') || $user->can('Setting Update');
                $canDelete = !$user || $user->can('Payment Method Delete') || $user->can('Setting Delete');

                $edit = '';
                $delete = '';

                if ($canEdit) {
                    $edit = '<a href="' . route('payment_methods.edit', $row->uuid) . '"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-slate-600 hover:bg-slate-100 transition-colors font-satoshi-medium"
                                data-bs-toggle="tooltip" title="Edit">
                                <i class="ri ri-edit-line text-lg"></i>
                             </a>';
                }

                if ($canDelete) {
                    $delete = '
                        <form action="' . route('payment_methods.destroy', $row->uuid) . '"
                              method="POST" style="display:inline-block;" class="delete-form m-0">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="button" class="inline-flex items-center justify-center w-8 h-8 rounded-full text-slate-600 hover:bg-slate-100 transition-colors delete-btn font-satoshi-medium"
                                data-id="' . $row->uuid . '"
                                data-bs-toggle="tooltip" title="Delete">
                                <i class="ri ri-delete-bin-line text-lg"></i>
                            </button>
                        </form>';
                }

                return '<div class="flex items-center space-x-2 justify-center">' . $edit . ' ' . $delete . '</div>';
            })
            ->rawColumns(['logo_display', 'type_badge', 'account_info', 'status', 'action']);
    }

    /**
     * Get query source of dataTable.
     */
    public function query(PaymentMethod $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('payment-methods-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->responsive(true)
            ->addTableClass('min-w-full divide-y divide-slate-200 overflow-hidden bg-white text-sm font-satoshi-medium text-slate-700')
            ->parameters([
                'dom' => '<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4 font-satoshi-medium"lf>' .
                         '<"overflow-x-auto w-full"tr>' .
                         '<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-4 font-satoshi-medium text-slate-500 text-sm"ip>',
                'language' => [
                    'search' => '<span class="text-slate-600 mr-2 font-satoshi-medium">Search:</span>',
                    'searchPlaceholder' => 'Search payment method...',
                    'lengthMenu' => '<span class="text-slate-600 mr-2 font-satoshi-medium">Show</span> _MENU_ <span class="text-slate-600 ml-2 font-satoshi-medium">Entries</span>',
                    'info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
                    'paginate' => [
                        'first' => '<i class="ri-arrow-left-double-line text-lg"></i>',
                        'previous' => '<i class="ri-arrow-left-s-line text-lg"></i>',
                        'next' => '<i class="ri-arrow-right-s-line text-lg"></i>',
                        'last' => '<i class="ri-arrow-right-double-line text-lg"></i>'
                    ],
                ],
            ]);
    }

    /**
     * Get columns.
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title('No')->searchable(false)->orderable(false)->width(50)->addClass('text-center px-4 py-3 bg-slate-50 font-satoshi-medium text-slate-500 border-b border-slate-200'),
            Column::make('logo_display')->title('Logo')->orderable(false)->searchable(false)->width(60)->addClass('text-center px-4 py-3 border-b border-slate-200'),
            Column::make('name')->title('Payment Method Name')->addClass('px-4 py-3 border-b border-slate-200 text-slate-900 font-semibold'),
            Column::make('type_badge')->title('Type')->addClass('px-4 py-3 border-b border-slate-200 text-center'),
            Column::make('provider')->title('Provider')->addClass('px-4 py-3 border-b border-slate-200'),
            Column::make('account_info')->title('Account Info')->addClass('px-4 py-3 border-b border-slate-200'),
            Column::make('status')->title('Status')->addClass('px-4 py-3 border-b border-slate-200 text-center'),
            Column::computed('action')
                ->title('Action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center px-4 py-3 border-b border-slate-200'),
        ];
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'PaymentMethod_' . date('YmdHis');
    }
}
