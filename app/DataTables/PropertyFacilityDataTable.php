<?php

namespace App\DataTables;

use App\Models\PropertyFacilities;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PropertyFacilityDataTable extends DataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('icon_display', function ($row) {
                if ($row->icon) {
                    return '<div class="w-9 h-9 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center mx-auto text-xl shadow-xs"><i class="' . e($row->icon) . '"></i></div>';
                } elseif ($row->image_path) {
                    return '<img src="' . asset('storage/' . $row->image_path) . '" class="w-10 h-10 object-cover rounded-lg shadow-xs mx-auto border border-slate-200">';
                }
                return '<div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-xl"><i class="ri-building-2-line"></i></div>';
            })
            ->addColumn('category_badge', function ($row) {
                return $row->category
                    ? '<span class="inline-flex items-center rounded-md bg-slate-100 px-2.5 py-1 text-xs font-satoshi-medium text-slate-700">' . e($row->category) . '</span>'
                    : '<span class="text-slate-400 text-xs">-</span>';
            })
            ->addColumn('status', function ($row) {
                return $row->status
                    ? '<span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-satoshi-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/10"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active</span>'
                    : '<span class="inline-flex items-center gap-1 rounded-full bg-rose-50 px-2.5 py-1 text-xs font-satoshi-medium text-rose-700 ring-1 ring-inset ring-rose-600/10"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Inactive</span>';
            })
            ->addColumn('action', function ($row) {
                $edit = '';
                $delete = '';

                if (auth()->user()->can('Property Facility Update')) {
                    $edit = '<a href="' . route('property_facilities.edit', $row->uuid) . '"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-600 hover:bg-slate-100 transition-colors font-satoshi-medium"
                                data-bs-toggle="tooltip" title="Edit">
                                <i class="ri ri-edit-line text-lg"></i>
                             </a>';
                }

                if (auth()->user()->can('Property Facility Delete')) {
                    $delete = '
                        <form action="' . route('property_facilities.destroy', $row->uuid) . '"
                              method="POST" style="display:inline-block;" class="delete-form m-0">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="button" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-rose-600 hover:bg-rose-50 transition-colors delete-btn font-satoshi-medium"
                                data-id="' . $row->uuid . '"
                                data-bs-toggle="tooltip" title="Delete">
                                <i class="ri ri-delete-bin-line text-lg"></i>
                            </button>
                        </form>';
                }

                return '<div class="flex items-center space-x-1 justify-center">' . $edit . ' ' . $delete . '</div>';
            })
            ->rawColumns(['icon_display', 'category_badge', 'status', 'action']);
    }

    /**
     * Get query source of dataTable.
     */
    public function query(PropertyFacilities $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('property-facilities-table')
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
                    'searchPlaceholder' => 'Search facility...',
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
            Column::make('icon_display')->title('Icon')->orderable(false)->searchable(false)->width(60)->addClass('text-center px-4 py-3 border-b border-slate-200'),
            Column::make('name')->title('Facility Name')->addClass('px-4 py-3 border-b border-slate-200 text-slate-900 font-semibold'),
            Column::make('category_badge')->title('Category')->addClass('px-4 py-3 border-b border-slate-200 text-center'),
            Column::make('description')->title('Description')->addClass('px-4 py-3 border-b border-slate-200 text-slate-500'),
            Column::make('status')->title('Status')->addClass('px-4 py-3 border-b border-slate-200 text-center'),
            Column::make('sort')->title('Sort')->addClass('px-4 py-3 border-b border-slate-200 text-center'),
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
        return 'PropertyFacilities_' . date('YmdHis');
    }
}
