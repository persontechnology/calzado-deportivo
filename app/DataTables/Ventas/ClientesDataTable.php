<?php

namespace App\DataTables\Ventas;

use App\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ClientesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function($clie){
                return view('ventas.facturas.selecionarCliente',['clie'=>$clie])->render();
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Ventas/Cliente $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('ventas-clientes-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('frtip')
                    ->ajax(['data' => 'function(d) { d.table = "posts"; }'])
                    ->parameters($this->getBuilderParameters())
                    ->orderBy(1);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->title('Selecionar')
                  ->addClass('text-center'),
            Column::make('apellidos'),
            Column::make('nombres'),
            Column::make('identificacion')->title('Identificación'),
            Column::make('telefono')->title('Teléfono'),
            Column::make('direccion')->title('Dirección'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Ventas/Clientes_' . date('YmdHis');
    }
}
