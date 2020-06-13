@extends('layouts.app',['title'=>'Buscar ventas'])
@section('breadcrumbs', Breadcrumbs::render('buscarFechaFechaFactura'))
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Buscar facturas
                    <form action="{{ route('buscarFechaFechaFactura') }}" class="mt-3" method="get">
                        <div class="form-row">
                            <div class="col bg-white">
                                <div class="md-form md-outline my-1">
                                    <input id="fechaInicial" name="desde" class="form-control @error('fechaInicial') is-invalid @enderror" value="{{ old('fechaInicial',$desde) }}"  required  type="date">
                                    <label class="active" for="fechaInicial">Desde<i class="text-danger">*</i></label>
                                    @error('fechaInicial')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col bg-white">
                                <div class="md-form md-outline my-1">
                                    <input id="fechaFinal" name="hasta" class="form-control @error('fechaFinal') is-invalid @enderror" value="{{ old('fechaFinal',$hasta) }}" type="date" required>
                                    <label class="active" for="fechaFinal">Hasta<i class="text-danger">*</i></label>
                                    @error('fechaFinal')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-dark my-0"  >Buscar facturas</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    
                    @if (count($facturas)>0)

                    
                        <div class="table-responsive">
                            <table class="table table-sm" id="tableFactura">
                                <thead>
                                    <th>Imprimir</th>
                                    <th>#_Factura</th>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Identificación</th>
                                    <th>Estado</th>
                                    <th>Forma de pago</th>
                                </thead>
                                <tbody>
                                    @php($total_entregado=0)
                                    @php($total_anulado=0)
                                    
                                    @foreach ($facturas as $fac)
                                        <tr>
                                            <td>
                                                <a role="button" onclick="imprimirFactura(this);" class="ml-1" data-url="{{ route('imprimirFactura',$fac->id) }}" data-toggle="tooltip" data-placement="top" data-title="IMPRIMIR FACTURA {{ $fac->numero }}">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            </td>
                                            <td>
                                                {{ $fac->numero }}
                                            </td>
                                            <td>
                                                {{ $fac->created_at }}
                                            </td>
                                            <td>
                                                {{ $fac->cliente->apellidos }} {{ $fac->cliente->nombres }}
                                            </td>
                                            <td>
                                                {{ $fac->cliente->identificacion }}
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $fac->estado=='Entregado'?'light':'danger' }}">
                                                    {{ $fac->estado }}
                                                </span>
                                            </td>
                                            <td>
                                                {{-- {{ $fac->forma_pago }} --}}
                                                @php($v_total=0)
                                                @foreach ($fac->facturaDetalles as $fd)
                                                    @php($v_total+=round(($fd->cantidad*$fd->valor_unitario),2))
                                                @endforeach
                                                {{ $v_total }}

                                                @if ($fac->estado=='Entregado')
                                                    @php($total_entregado+=$v_total)
                                                @else
                                                    @php($total_anulado+=$v_total)
                                                @endif
                                                
                                            </td>
                                        </tr>    

                                        
                                    @endforeach
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        
                                        <td colspan="6">
                                            <p>
                                                <span class="badge badge-pill badge-light">Facturas entregadas: {{ $facturas_entregadas }}</span>
                                                <span class="badge badge-pill badge-dark">Facturas anuladas: {{ $facturas_anulados }}</span>
                                            </p>
                                        </td>
                                        <td>
                                            Total entregado: <strong>{{ round($total_entregado,2) }}</strong> <br>
                                            Total anulado: <strong>{{ round($total_anulado,2) }}</strong>
                                            
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-dark" role="alert">
                            No existe facturas con fechas desde: {{ $desde }} hasta: {{ $hasta }}
                        </div>
                    @endif
                    
                </div>

            </div>
        </div>
    </div>
</div>



  
  <!-- Central Modal Small -->
  <div class="modal fade" id="modalFactura" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
  
    <!-- Change class .modal-sm to change the size of the modal -->
    <div class="modal-dialog modal-lg" role="document">
  
  
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title w-100" id="myModalLabel">
              <strong id="tituloFactura">IMPRIMIR FACTURA</strong>
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" id="contenedorFactura" src="" allowfullscreen></iframe>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">CERRAR</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Central Modal Small -->



@push('linksCabeza')
{{--  datatable  --}}
<link rel="stylesheet" type="text/css" href="{{ asset('js/DataTables/datatables.min.css') }}"/>
<script type="text/javascript" src="{{ asset('js/DataTables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>

{{-- block --}}
<script src="{{ asset('js/jquery.blockUI.js') }}"></script>

@endpush

@prepend('linksPie')
    <script>
    $('#ventas').addClass('active');
    $('#facturas').addClass('active');
    
    $('#tableFactura').DataTable({
        "paging": false,
        "language": {
    
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla =(",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad"
            }
        }
    });

    function imprimirFactura(arg){
        $('#modalFactura').modal('show');
        $('#contenedorFactura').attr('src',$(arg).data('url'));
        $('#tituloFactura').html($(arg).data('title'));
    }

 

    </script>
    
@endprepend


@endsection
