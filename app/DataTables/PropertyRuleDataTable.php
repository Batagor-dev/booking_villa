<?php

namespace App\DataTables;

use App\Models\PropertyRule;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PropertyRuleDataTable extends DataTable
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
                    return '<div class="w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto text-xl shadow-xs"><i class="' . e($row->icon) . '"></i></div>';
                }
                return '<div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-xl"><i class="ri-shield-line"></i></div>';
            })
            ->addColumn('type_badge', function ($row) {
                $labels = [
                    'all' => 'Semua Tipe Properti',
                    'Villa' => 'Villa',
                    'Resort' => 'Resort',
                    'Boutique Hotel' => 'Boutique Hotel',
                    'Apartment' => 'Apartment',
                    'Private House' => 'Private House',
                ];
                $label = $labels[$row->property_type] ?? $row->property_type;
                $isAll = $row->property_type === 'all';
                $badgeBg = $isAll ? 'bg-purple-50 text-purple-700 ring-purple-600/20' : 'bg-blue-50 text-blue-700 ring-blue-600/20';
                $dotBg = $isAll ? 'bg-purple-500' : 'bg-blue-500';
                return '<span class="inline-flex items-center gap-1 rounded-full ' . $badgeBg . ' px-2.5 py-1 text-xs font-satoshi-medium ring-1 ring-inset"><span class="w-1.5 h-1.5 rounded-full ' . $dotBg . '"></span> ' . e($label) . '</span>';
            })
            ->addColumn('status', function ($row) {
                return $row->is_active
                    ? '<span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-satoshi-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/10"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active</span>'
                    : '<span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-satoshi-medium text-slate-600"><span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Inactive</span>';
            })
            ->addColumn('action', function ($row) {
                $edit = '<a href="' . route('property_rules.edit', $row->uuid) . '"
                            class="inline-flex items-center justify-center w-8 h-8 rounded-full text-slate-600 hover:bg-slate-100 transition-colors font-satoshi-medium"
                            data-bs-toggle="tooltip" title="Edit">
                            <i class="ri ri-edit-line text-lg"></i>
                         </a>';

                $delete = '
                    <form action="' . route('property_rules.destroy', $row->uuid) . '"
                          method="POST" style="display:inline-block;" class="delete-form m-0">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="button" class="inline-flex items-center justify-center w-8 h-8 rounded-full text-slate-600 hover:bg-slate-100 transition-colors delete-btn font-satoshi-medium"
                            data-id="' . $row->uuid . '"
                            data-bs-toggle="tooltip" title="Delete">
                            <i class="ri ri-delete-bin-line text-lg"></i>
                        </button>
                    </form>';

                return '<div class="flex items-center space-x-2 justify-center">' . $edit . ' ' . $delete . '</div>';
            })
            ->rawColumns(['icon_display', 'type_badge', 'status', 'action']);
    }

    /**
     * Get query source of dataTable.
     */
    public function query(PropertyRule $model)
    {
        return $model->newQuery()->orderBy('sort_order', 'asc');
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('property-rules-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(4, 'asc')
            ->responsive(true)
            ->addTableClass('min-w-full divide-y divide-slate-200 overflow-hidden bg-white text-sm font-satoshi-medium text-slate-700')
            ->parameters([
                'dom' => '<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4 font-satoshi-medium"lf>' .
                         '<"overflow-x-auto w-full"tr>' .
                         '<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-4 font-satoshi-medium text-slate-500 text-sm"ip>',
                'language' => [
                    'search' => '<span class="text-slate-600 mr-2 font-satoshi-medium">Search:</span>',
                    'searchPlaceholder' => 'Search rules...',
                    'lengthMenu' => '<span class="text-slate-600 mr-2 font-satoshi-medium">Show</span> _MENU_ <span class="text-slate-600 ml-2 font-satoshi-medium">Entries</span>',
                    'info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
                    'paginate' => [
                        'first' => '<i class="ri-arrow-left-double-line text-lg"></i>',
                        'previous' => '<i class="ri-arrow-left-s-line text-lg"></i>',
                        'next' => '<i class="ri-arrow-right-s-line text-lg"></i>',
                        'last' => '<i class="ri-arrow-right-double-line text-lg"></i>'
                    ]
                ]
            ]);
    }

    /**
     * Get columns.
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title('#')->addClass('text-center w-12'),
            Column::computed('icon_display')->title('Icon')->addClass('text-center w-16'),
            Column::make('title')->title('Judul Peraturan'),
            Column::computed('type_badge')->title('Tipe Properti')->addClass('text-center'),
            Column::make('description')->title('Deskripsi Rules'),
            Column::make('sort_order')->title('Urutan')->addClass('text-center w-20'),
            Column::computed('status')->title('Status')->addClass('text-center'),
            Column::computed('action')->title('Aksi')->addClass('text-center w-28'),
        ];
    }
}
