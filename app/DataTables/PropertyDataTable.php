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
                    $src = \Illuminate\Support\Str::startsWith($row->main_image, ['http://', 'https://'])
                        ? $row->main_image
                        : asset('storage/' . $row->main_image);
                    return '<img src="' . e($src) . '" class="w-16 h-12 object-cover rounded-xl shadow-xs mx-auto border border-slate-200/80 transition-transform hover:scale-105">';
                }
                return '<div class="w-16 h-12 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-xl border border-slate-200/60"><i class="ri-building-4-line"></i></div>';
            })
            ->addColumn('property_info', function ($row) {
                $code = $row->code ? '<span class="text-[11px] px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 font-mono border border-slate-200/60 ml-1.5">' . e($row->code) . '</span>' : '';
                $type = '<span class="inline-block text-[11px] font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 mt-1">' . e($row->type) . '</span>';
                
                return '<div class="space-y-0.5">
                    <div class="font-satoshi-bold text-slate-900 text-sm flex items-center flex-wrap gap-1">' . e($row->name) . $code . '</div>
                    <div>' . $type . '</div>
                </div>';
            })
            ->addColumn('price_info', function ($row) {
                return '<div><span class="font-satoshi-bold text-slate-900 text-sm">' . format_rupiah($row->price ?? 0) . '</span> <span class="text-[10px] text-slate-400">/ malam</span></div>';
            })
            ->addColumn('specs', function ($row) {
                return '<div class="flex flex-col gap-1 text-xs text-slate-600 font-satoshi-medium">
                    <span class="inline-flex items-center gap-1.5"><i class="ri-hotel-bed-line text-amber-500"></i> ' . e($row->bedrooms ?? 1) . ' Kamar</span>
                    <span class="inline-flex items-center gap-1.5"><i class="ri-user-3-line text-emerald-500"></i> ' . e($row->capacity ?? 2) . ' Tamu</span>
                </div>';
            })
            ->addColumn('location', function ($row) {
                $city = $row->city ?? '-';
                $prov = $row->province ? ', ' . $row->province : '';
                return '<div class="text-xs font-satoshi-medium text-slate-800 flex items-center gap-1">
                    <i class="ri-map-pin-2-fill text-rose-500 text-sm"></i>
                    <span>' . e($city . $prov) . '</span>
                </div>';
            })
            ->addColumn('destination_name', function ($row) {
                return $row->destination
                    ? '<span class="inline-flex items-center gap-1 rounded-md bg-teal-50 px-2 py-0.5 text-xs font-satoshi-bold text-teal-700 border border-teal-200/60"><i class="ri-map-pin-2-line"></i> ' . e($row->destination->name) . '</span>'
                    : '<span class="text-slate-400 text-xs">-</span>';
            })
            ->addColumn('rating_info', function ($row) {
                $rating = number_format($row->rating ?? 0, 2);
                return '<div class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-satoshi-bold border border-amber-200/60">
                    <i class="ri-star-fill text-amber-500"></i>
                    <span>' . $rating . '</span>
                </div>';
            })
            ->addColumn('status', function ($row) {
                $statusBadge = $row->status
                    ? '<span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-satoshi-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/10"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active</span>'
                    : '<span class="inline-flex items-center gap-1 rounded-full bg-rose-50 px-2.5 py-1 text-xs font-satoshi-medium text-rose-700 ring-1 ring-inset ring-rose-600/10"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Inactive</span>';

                $featuredBadge = $row->is_featured
                    ? '<span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-[11px] font-satoshi-bold text-amber-700 ring-1 ring-inset ring-amber-600/20"><i class="ri-star-fill text-amber-500"></i> Featured</span>'
                    : '';

                return '<div class="flex flex-col items-center gap-1.5">' . $statusBadge . $featuredBadge . '</div>';
            })
            ->addColumn('action', function ($row) {
                $edit = '';
                $delete = '';

                if (auth()->user()->can('Property Update')) {
                    $edit = '<a href="' . route('properties.edit', $row->slug) . '"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors font-satoshi-medium"
                                data-bs-toggle="tooltip" title="Edit Property">
                                <i class="ri ri-edit-line text-base"></i>
                             </a>';
                }

                if (auth()->user()->can('Property Delete')) {
                    $delete = '
                        <form action="' . route('properties.destroy', $row->slug) . '"
                              method="POST" style="display:inline-block;" class="delete-form m-0">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="button" class="inline-flex items-center justify-center w-8 h-8 rounded-full text-slate-600 hover:bg-rose-50 hover:text-rose-600 transition-colors delete-btn font-satoshi-medium"
                                data-id="' . $row->slug . '"
                                data-bs-toggle="tooltip" title="Delete Property">
                                <i class="ri ri-delete-bin-line text-base"></i>
                            </button>
                        </form>';
                }

                return '<div class="flex items-center space-x-1 justify-center">' . $edit . ' ' . $delete . '</div>';
            })
            ->rawColumns(['image_preview', 'property_info', 'destination_name', 'price_info', 'specs', 'location', 'rating_info', 'status', 'action']);
    }

    /**
     * Get query source of dataTable.
     */
    public function query(Properties $model)
    {
        return $model->newQuery()->with(['destination'])->withCount('facilities');
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
            ->orderBy(1, 'asc')
            ->responsive(true)
            ->addTableClass('min-w-full divide-y divide-slate-200 overflow-hidden bg-white text-sm font-satoshi-medium text-slate-700')
            ->parameters([
                'dom' => '<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4 font-satoshi-medium"lf>' .
                         '<"overflow-x-auto w-full border border-slate-100 rounded-2xl shadow-xs"tr>' .
                         '<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-4 font-satoshi-medium text-slate-500 text-sm"ip>',
                'language' => [
                    'search' => '<span class="text-slate-600 mr-2 font-satoshi-medium">Search:</span>',
                    'searchPlaceholder' => 'Cari nama, kota, tipe...',
                    'lengthMenu' => '<span class="text-slate-600 mr-2 font-satoshi-medium">Tampilkan</span> _MENU_ <span class="text-slate-600 ml-2 font-satoshi-medium">Data</span>',
                    'info' => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
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
            Column::make('DT_RowIndex')->title('No')->searchable(false)->orderable(false)->width(40)->addClass('text-center px-3 py-3.5 bg-slate-50/80 font-satoshi-bold text-slate-500 border-b border-slate-200'),
            Column::make('image_preview')->title('Cover')->orderable(false)->searchable(false)->width(90)->addClass('text-center px-3 py-3.5 bg-slate-50/80 font-satoshi-bold text-slate-700 border-b border-slate-200'),
            Column::make('property_info')->title('Informasi Properti')->addClass('px-4 py-3.5 bg-slate-50/80 font-satoshi-bold text-slate-700 border-b border-slate-200'),
            Column::make('destination_name')->title('Destinasi')->addClass('px-4 py-3.5 bg-slate-50/80 font-satoshi-bold text-slate-700 border-b border-slate-200'),
            Column::make('price_info')->title('Harga Per Malam')->addClass('px-4 py-3.5 bg-slate-50/80 font-satoshi-bold text-slate-700 border-b border-slate-200'),
            Column::make('specs')->title('Spesifikasi')->orderable(false)->addClass('px-4 py-3.5 bg-slate-50/80 font-satoshi-bold text-slate-700 border-b border-slate-200'),
            Column::make('location')->title('Lokasi')->addClass('px-4 py-3.5 bg-slate-50/80 font-satoshi-bold text-slate-700 border-b border-slate-200'),
            Column::make('rating_info')->title('Rating')->addClass('text-center px-4 py-3.5 bg-slate-50/80 font-satoshi-bold text-slate-700 border-b border-slate-200'),
            Column::make('status')->title('Status')->addClass('text-center px-4 py-3.5 bg-slate-50/80 font-satoshi-bold text-slate-700 border-b border-slate-200'),
            Column::computed('action')
                ->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->width(90)
                ->addClass('text-center px-4 py-3.5 bg-slate-50/80 font-satoshi-bold text-slate-700 border-b border-slate-200'),
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
