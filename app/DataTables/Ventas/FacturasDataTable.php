<?php

namespace App\DataTables\Ventas;

use App\Models\Factura;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class FacturasDataTable extends DataTable
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
            ->editColumn('cliente_id',function($fac){
                return $fac->cliente->apellidos.' '.$fac->cliente->nombres;
            })
            ->editColumn('created_at',function($fac){
                return $fac->created_at;
            })
            ->editColumn('iva',function($fac){
                return $fac->cliente->identificacion;
            })
            ->filterColumn('iva',function($fac, $keyword){
                $fac->whereHas('cliente', function($cli) use ($keyword) {
                    $cli->whereRaw("identificacion like ?", ["%{$keyword}%"]);
                });            
            })
            ->editColumn('estado',function($fac){
                return view('ventas.facturas.estado',['fac'=>$fac])->render();
            })
            ->addColumn('action',function($fac){
                return view('ventas.facturas.opciones',['fac'=>$fac])->render();
            })
            ->rawColumns(['action','estado']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Ventas/Factura $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Factura $model)
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
                    ->setTableId('ventas-facturas-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('frtip')
                    ->orderBy(1)
                    ->parameters($this->getBuilderParameters());
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
                  ->searchable(false)
                  ->addClass('text-center'),
            // Column::make('id'),
            Column::make('numero')->title('#_Factura'),
            Column::make('created_at')->title('Fecha'),
            Column::make('cliente_id')->title('Cliente'),
            Column::make('iva')->title('Identificación'),
            Column::make('estado')->title('Estado'),
            Column::make('forma_pago')->title('Forma de pago'),
            
            

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Ventas_Facturas_' . date('YmdHis');
    }
}
