@extends('layouts.app',['title'=>'Ventas'])
@section('breadcrumbs', Breadcrumbs::render('facturas'))
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Facturas
                    
                    
                    <form action="{{ route('buscarFechaFechaFactura') }}" method="get" class="float-right my-0">
                      <input type="hidden" name="desde" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                      <input type="hidden" name="hasta" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">

                      <div class="btn-group btn-group-sm" role="group" aria-label="...">
                        <a  href="{{ route('nuevaFactura') }}" class="btn btn-white float-right" data-toggle="tooltip" data-placement="top" title="Nueva factura">
                          <i class="fas fa-plus text-primary"></i>
                        </a>
                        <button type="submit" class="btn btn-white float-right" data-toggle="tooltip" data-placement="top" title="Buscar facturas">
                          <i class="fas fa-search text-primary"></i>
                        </button>
                        
                      </div>


                      
                    </form>
                    
                    

                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        {{$dataTable->table()}}
                    </div>
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

@endpush

@prepend('linksPie')
    <script>
    $('#ventas').addClass('active');
    $('#facturas').addClass('active');
    

    function imprimirFactura(arg){
        $('#modalFactura').modal('show');
        $('#contenedorFactura').attr('src',$(arg).data('url'));
        $('#tituloFactura').html($(arg).data('title'));
    }

    </script>
    {!! $dataTable->scripts() !!}
@endprepend


@endsection
