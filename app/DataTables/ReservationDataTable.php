<?php

namespace App\DataTables;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ReservationDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function($query){
                $delete = "<a href='".route('admin.reservation.destroy', $query->id)."' class='btn btn-danger delete-item ml-2'><i class='fas fa-trash'></i></a>";

                return $delete;
            })
            ->addColumn('created_at', function($query){
                return date('d-m-y', strtotime($query->created_at));
            })
            ->addColumn('status', function($query){
                $html ='<select class="form-control reservation_status" data-id="'.$query->id.'">
                <option '.($query->status === Reservation::STATUS_PENDING ? 'selected' : '').' value="'. Reservation::STATUS_PENDING .'">'. Reservation::STATUS_PENDING .'</option>
                <option '.($query->status === Reservation::STATUS_APPROVED ? 'selected' : '').' value="'. Reservation::STATUS_APPROVED .'">'. Reservation::STATUS_APPROVED .'</option>
                <option '.($query->status === Reservation::STATUS_COMPLETE ? 'selected' : '').' value="'. Reservation::STATUS_COMPLETE .'">'. Reservation::STATUS_COMPLETE .'</option>
                <option  '.($query->status === Reservation::STATUS_CANCEL ? 'selected' : '').' value="'. Reservation::STATUS_CANCEL .'">'. Reservation::STATUS_CANCEL .'</option>
                </select>';

                return $html;
            })
            ->rawColumns(['status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Reservation $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Reservation $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('reservation-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('phone'),
            Column::make('date'),
            Column::make('time'),
            Column::make('created_at'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Reservation_' . date('YmdHis');
    }
}
