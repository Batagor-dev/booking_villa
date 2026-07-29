<?php

namespace App\DataTables;

use App\Models\Properties;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PropertyDataTable extends DataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('image_preview', function ($row) {
                if ($row->main_image) {
                    return '<img src="' . asset('storage/' . $row->main_image) . '" class="w-16 h-12 object-cover rounded-xl shadow-xs mx-auto border border-slate-200">';
                }
                return '<div class="w-16 h-12 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-xl"><i class="ri-building-4-line"></i></div>';
            })
            ->addColumn('property_info', function ($row) {
                $code = $row->code ? '<span class="text-xs px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 font-mono ml-1.5">' . e($row->code) . '</span>' : '';
                return '<div><div class="font-satoshi-bold text-slate-900 text-base flex items-center">' . e($row->name) . $code . '</div><div class="text-xs text-slate-500 font-satoshi-regular">' . e($row->type) . '</div></div>';
            })
            ->addColumn('location', function ($row) {
                $city = $row->city ?? '-';
                $prov = $row->province ? ', ' . $row->province : '';
                return '<span class="text-slate-700 font-satoshi-medium"><i class="ri-map-pin-line text-indigo-500 mr-1"></i>' . e($city . $prov) . '</span>';
            })
            ->addColumn('facilities_count', function ($row) {
                $count = $row->facilities_count ?? $row->facilities()->count();
                return '<span class="inline-flex items-center gap-1 rounded-lg bg-indigo-50 px-2.5 py-1 text-xs font-satoshi-bold text-indigo-700"><i class="ri-checkbox-circle-line"></i> ' . $count . ' Facilities</span>';
            })
            ->addColumn('status', function ($row) {
                $statusBadge = $row->status
                    ? '<span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-satoshi-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/10"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active</span>'
                    : '<span class="inline-flex items-center gap-1 rounded-full bg-rose-50 px-2.5 py-1 text-xs font-satoshi-medium text-rose-700 ring-1 ring-inset ring-rose-600/10"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Inactive</span>';

                $featuredBadge = $row->is_featured
                    ? '<span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2 py-0.5 text-xs font-satoshi-medium text-amber-700 ring-1 ring-inset ring-amber-600/10 ml-1"><i class="ri-star-fill text-amber-500"></i> Featured</span>'
                    : '';

                return '<div class="flex flex-col items-center gap-1">' . $statusBadge . $featuredBadge . '</div>';
            })
            ->addColumn('action', function ($row) {
                $edit = '';
                $delete = '';

                if (auth()->user()->can('Property Update')) {
                    $edit = '<a href="' . route('properties.edit', $row->uuid) . '"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-slate-600 hover:bg-slate-100 transition-colors font-satoshi-medium"
                                data-bs-toggle="tooltip" title="Edit">
                                <i class="ri ri-edit-line text-lg"></i>
                             </a>';
                }

                if (auth()->user()->can('Property Delete')) {
                    $delete = '
                        <form action="' . route('properties.destroy', $row->uuid) . '"
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
            ->rawColumns(['image_preview', 'property_info', 'location', 'facilities_count', 'status', 'action']);
    }

    /**
     * Get query source of dataTable.
     */
    public function query(Properties $model)
    {
        return $model->newQuery()->withCount('facilities');
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('properties-table')
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
                    'searchPlaceholder' => 'Search property...',
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
            Column::make('image_preview')->title('Cover')->orderable(false)->searchable(false)->width(80)->addClass('text-center px-4 py-3 border-b border-slate-200'),
            Column::make('property_info')->title('Property Details')->addClass('px-4 py-3 border-b border-slate-200'),
            Column::make('location')->title('Location')->addClass('px-4 py-3 border-b border-slate-200'),
            Column::make('facilities_count')->title('Facilities')->addClass('px-4 py-3 border-b border-slate-200 text-center'),
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
        return 'Properties_' . date('YmdHis');
    }
}
