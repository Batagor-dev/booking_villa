<?php

namespace App\DataTables;

use App\Models\Review;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ReviewDataTable extends DataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('property', function ($review) {
                return $review->property 
                    ? '<span class="font-satoshi-bold text-slate-900">'.e($review->property->name).'</span>' 
                    : '<span class="text-slate-400">-</span>';
            })
            ->addColumn('user', function ($review) {
                if (!$review->user) {
                    return '<span class="text-slate-400">Guest</span>';
                }
                $u = $review->user;
                $userAvatar = ($u->foto && str_starts_with($u->foto, 'http'))
                    ? $u->foto
                    : (($u->foto && (str_starts_with($u->foto, 'avatar-') || str_contains($u->foto, '.')))
                        ? asset('assets/img/avatar/' . $u->foto)
                        : asset('assets/img/avatar/avatar-1.jpg'));

                return '<div class="flex items-center gap-3">
                            <img src="'.e($userAvatar).'" alt="'.e($u->name).'" class="w-9 h-9 rounded-full object-cover border border-slate-200 shrink-0">
                            <div>
                                <div class="font-satoshi-bold text-xs text-slate-900">'.e($u->name).'</div>
                                <div class="text-[11px] text-slate-400 font-mono">'.e($u->email).'</div>
                            </div>
                        </div>';
            })
            ->addColumn('rating', function ($review) {
                $stars = '';
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $review->rating) {
                        $stars .= '<i class="ri-star-fill text-amber-400"></i>';
                    } else {
                        $stars .= '<i class="ri-star-line text-slate-200"></i>';
                    }
                }
                return '<div class="flex items-center gap-1">'.$stars.' <span class="text-xs font-bold text-slate-700 ml-1">('.$review->rating.')</span></div>';
            })
            ->addColumn('comment', function ($review) {
                return '<div class="text-xs text-slate-600 line-clamp-2">"'.e($review->comment).'"</div>';
            })
            ->addColumn('status', function ($review) {
                if ($review->status === 'approved') {
                    return '<span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-satoshi-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/10">Dipublikasikan</span>';
                } elseif ($review->status === 'pending') {
                    return '<span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-satoshi-semibold text-amber-700 ring-1 ring-inset ring-amber-600/10">Pending</span>';
                }
                return '<span class="inline-flex items-center gap-1 rounded-full bg-rose-50 px-2.5 py-1 text-xs font-satoshi-semibold text-rose-700 ring-1 ring-inset ring-rose-600/10">Ditolak</span>';
            })
            ->addColumn('admin_reply', function ($review) {
                if (!empty($review->admin_reply)) {
                    return '<span class="inline-flex items-center gap-1 rounded-lg bg-slate-100 px-2 py-1 text-xs font-satoshi-medium text-slate-700" title="'.e($review->admin_reply).'"><i class="ri-reply-fill text-slate-500"></i> Ada Balasan</span>';
                }
                return '<span class="text-slate-400 text-xs">-</span>';
            })
            ->addColumn('created_at', function ($review) {
                return $review->created_at ? $review->created_at->format('d M Y, H:i') : '-';
            })
            ->addColumn('action', function ($row) {
                $edit = '';
                $delete = '';

                if (auth()->user()->can('Review Update') || auth()->user()->hasRole(['Admin', 'Super Admin', 'admin', 'super-admin'])) {
                    $edit = '<a href="'.route('reviews.edit', $row->uuid).'"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-slate-600 hover:bg-slate-100 transition-colors font-satoshi-medium"
                                data-bs-toggle="tooltip" title="Edit / Moderasi">
                                <i class="ri ri-edit-line text-lg"></i>
                             </a>';
                }

                if (auth()->user()->can('Review Delete') || auth()->user()->hasRole(['Admin', 'Super Admin', 'admin', 'super-admin'])) {
                    $delete = '
                        <form action="'.route('reviews.destroy', $row->uuid).'"
                              method="POST" style="display:inline-block;" class="delete-form m-0">
                            '.csrf_field().method_field('DELETE').'
                            <button type="button" class="inline-flex items-center justify-center w-8 h-8 rounded-full text-slate-600 hover:bg-slate-100 transition-colors delete-btn font-satoshi-medium"
                                data-id="'.$row->uuid.'"
                                data-bs-toggle="tooltip" title="Hapus">
                                <i class="ri ri-delete-bin-line text-lg"></i>
                            </button>
                        </form>';
                }

                return '<div class="flex items-center space-x-1 justify-center">' . $edit.' '.$delete . '</div>';
            })
            ->rawColumns(['property', 'user', 'rating', 'comment', 'status', 'admin_reply', 'action']);
    }

    /**
     * Get query source of dataTable.
     */
    public function query(Review $model)
    {
        return $model->newQuery()->with(['property', 'user', 'booking'])->latest();
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('reviews-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0, 'desc')
            ->responsive(true)
            ->addTableClass('min-w-full divide-y divide-slate-200 overflow-hidden bg-white text-sm font-satoshi-medium text-slate-700')
            ->parameters([
                'dom' => '<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4 font-satoshi-medium"lf>' .
                         '<"overflow-x-auto w-full"tr>' .
                         '<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-4 font-satoshi-medium text-slate-500 text-sm"ip>',
                'language' => [
                    'search' => '<span class="text-slate-600 mr-2 font-satoshi-medium">Search:</span>',
                    'searchPlaceholder' => 'Search reviews...',
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
            Column::make('DT_RowIndex')->title('No')->orderable(false)->searchable(false)->addClass('text-center w-12'),
            Column::make('property')->title('Villa Properti'),
            Column::make('user')->title('Pelanggan'),
            Column::make('rating')->title('Rating'),
            Column::make('comment')->title('Ulasan / Komentar'),
            Column::make('status')->title('Status Moderasi')->addClass('text-center'),
            Column::make('admin_reply')->title('Balasan Admin')->addClass('text-center'),
            Column::make('created_at')->title('Tanggal')->addClass('text-center'),
            Column::computed('action')->title('Aksi')->exportable(false)->printable(false)->addClass('text-center w-24'),
        ];
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'Reviews_' . date('YmdHis');
    }
}
