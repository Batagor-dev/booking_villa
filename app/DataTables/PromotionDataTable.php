<?php

namespace App\DataTables;

use App\Models\Promotion;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PromotionDataTable extends DataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('promotion_type', function ($row) {
                return $row->promotion_type === 'automatic'
                    ? '<span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-satoshi-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">Automatic</span>'
                    : '<span class="inline-flex items-center rounded-md bg-purple-50 px-2 py-0.5 text-xs font-satoshi-medium text-purple-700 ring-1 ring-inset ring-purple-700/10">Code: <code class="font-mono ml-1 bg-purple-100/50 px-1 py-0.5 rounded">' . e($row->code) . '</code></span>';
            })
            ->addColumn('discount', function ($row) {
                return $row->discount_type === 'percentage'
                    ? number_format($row->discount_value, 0) . '%'
                    : 'Rp' . number_format($row->discount_value, 0, ',', '.');
            })
            ->addColumn('period', function ($row) {
                return $row->start_date->format('d M Y H:i') . ' - ' . $row->end_date->format('d M Y H:i');
            })
            ->addColumn('status', function ($row) {
                $now = now();
                if (!$row->status) {
                    return '<span class="inline-flex items-center gap-1 rounded-full bg-rose-50 px-2.5 py-1 text-xs font-satoshi-medium text-rose-700 ring-1 ring-inset ring-rose-600/10"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Inactive</span>';
                }
                if ($now->lt($row->start_date)) {
                    return '<span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-satoshi-medium text-amber-700 ring-1 ring-inset ring-amber-600/10"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Scheduled</span>';
                }
                if ($now->gt($row->end_date)) {
                    return '<span class="inline-flex items-center gap-1 rounded-full bg-slate-50 px-2.5 py-1 text-xs font-satoshi-medium text-slate-700 ring-1 ring-inset ring-slate-600/10"><span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Expired</span>';
                }
                return '<span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-satoshi-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/10"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active</span>';
            })
            ->addColumn('action', function ($row) {
                $edit = '';
                $delete = '';

                if (auth()->user()->can('Promotion Update') || auth()->user()->hasRole('Super Admin')) {
                    $edit = '<a href="' . route('promotion.edit', $row->id) . '"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-slate-600 hover:bg-slate-100 transition-colors font-satoshi-medium"
                                data-bs-toggle="tooltip" title="Edit">
                                <i class="ri ri-edit-line text-lg"></i>
                             </a>';
                }

                if (auth()->user()->can('Promotion Delete') || auth()->user()->hasRole('Super Admin')) {
                    $delete = '
                        <form action="' . route('promotion.destroy', $row->id) . '"
                              method="POST" style="display:inline-block;" class="delete-form m-0">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="button" class="inline-flex items-center justify-center w-8 h-8 rounded-full text-slate-600 hover:bg-slate-100 transition-colors delete-btn font-satoshi-medium"
                                data-id="' . $row->id . '"
                                data-bs-toggle="tooltip" title="Delete">
                                <i class="ri ri-delete-bin-line text-lg"></i>
                            </button>
                        </form>';
                }

                return '<div class="flex items-center space-x-2 justify-center">' . $edit . ' ' . $delete . '</div>';
            })
            ->rawColumns(['promotion_type', 'discount', 'period', 'status', 'action']);
    }

    /**
     * Get query source of dataTable.
     */
    public function query(Promotion $model)
    {
        return $model->newQuery()->latest();
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('promotions-table')
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
                    'searchPlaceholder' => 'Search promotion...',
                    'lengthMenu' => '<span class="text-slate-600 mr-2 font-satoshi-medium">Show</span> _MENU_ <span class="text-slate-600 ml-2 font-satoshi-medium">entries</span>',
                    'paginate' => [
                        'next' => '<i class="ri-arrow-right-s-line"></i>',
                        'previous' => '<i class="ri-arrow-left-s-line"></i>'
                    ]
                ],
                'pagingType' => 'simple_numbers',
            ]);
    }

    /**
     * Get columns.
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title('No')->searchable(false)->orderable(false)->width(30)->addClass('text-center'),
            Column::make('name')->title('Name'),
            Column::make('promotion_type')->title('Type'),
            Column::make('discount')->title('Discount'),
            Column::make('period')->title('Active Period'),
            Column::make('status')->title('Status')->addClass('text-center'),
            Column::computed('action')->exportable(false)->printable(false)->width(100)->addClass('text-center'),
        ];
    }
}
