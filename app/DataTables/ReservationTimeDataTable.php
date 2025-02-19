<?php

namespace App\DataTables;

use App\Models\ReservationTime;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Config;
class ReservationTimeDataTable extends DataTable
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
               $edit = "<a href='".route('admin.reservation-time.edit', $query->id)."' class='btn btn-primary'><i class='fas fa-edit'></i></a>";
               $delete = "<a href='".route('admin.reservation-time.destroy', $query->id)."' class='btn btn-danger delete-item ml-2'><i class='fas fa-trash'></i></a>";

               return $edit.$delete;
           })
           ->addColumn('status', function($query){
               if($query->status === Config::get('params.status.active')){
                   return '<span class="badge badge-primary">' . array_search(Config::get('params.status.active'), Config::get('params.status')) . '</span>';
               }else {
                   return '<span class="badge badge-danger">' . array_search(Config::get('params.status.inactive'), Config::get('params.status')) . '</span>';
               }
           })
           ->rawColumns(['action', 'status'])
           ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ReservationTime $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ReservationTime $model): QueryBuilder
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
                    ->setTableId('reservationtime-table')
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
            Column::make('start_time'),
            Column::make('end_time'),
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
        return 'ReservationTime_' . date('YmdHis');
    }
}
