@extends('layouts.app',['title'=>'Nueva Venta'])
@section('breadcrumbs', Breadcrumbs::render('nuevaFactura'))
@section('content')

<div class="container-fluid">
    
    
    <div class="alert alert-dark alert-dismissible fade show bor" id="alertaErrores" style="display: none;" role="alert">
        <ul id="listaErrores"></ul>

        <button type="button" class="close" onclick="cerrarAlertErrorres(this);">
            <i class="fas fa-times"></i>
        </button>
    </div>

    
    
      
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="btn-group" role="group" aria-label="Basic example" id="">
                        <a href="{{ route('nuevaFactura') }}" class="btn btn-unique">
                            <i class="fas fa-cart-plus fa-2x"></i> NUEVA VENTA
                        </a>
                        
                        <div id="contenedorBotonesImprimir">

                        </div>
                    </div>
                    
                </div>

                <div class="card-body">
                    <p><strong>LISTADO DE PRODUCTOS</strong></p>
                    <div class="table-responsive">
                        {!! $pdt->html()->table() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            
            <form action="{{ route('guardarFactura') }}" method="POST" id="formFactura">
                @csrf
                <div class="card">
                    
                    <div class="card-header bg-transparent">
                        <div class="row mb-2">
                            <div class="col">
                                <button class="btn btn-elegant my-0 btn-sm" type="button" data-toggle="modal" data-target="#modalListadoClientes">
                                    <i class="fas fa-user-check fa-2x"></i> Buscar cliente
                                </button>
                            </div>
                            <div class="col">
                                <div class="md-form md-outline my-0">
                                    <input id="form-lg"  class="form-control is-invalid border-danger text-danger" type="text" value="" name="numero" required>
                                    <label for="form-lg" class="active text-danger"><strong>NÚMERO DE FACTURA</strong></label>
                                    @if ($ultimaFactura)
                                        <small class="form-text text-muted text-right">Última factura: <strong id="ultimaFactura">{{ $ultimaFactura->numero }}</strong></small>
                                    @endif    
                                </div>
                                
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col">
                                <div class="md-form md-outline my-0">
                                    <input type="text" value="{{ $consumidor->identificacion??'' }}" onkeyup="buscarCliente(this);" id="txt_identificacion" name="identificacion" class="form-control" required>
                                    <label for="txt_identificacion">Identificación:<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="md-form md-outline my-0">
                                    <input type="text" value="{{ $consumidor->apellidos??'' }}" id="txt_apellidos" name="apellidos" class="form-control" required>
                                    <label for="txt_apellidos">Apellidos:<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="md-form md-outline my-0">
                                    <input type="text" value="{{ $consumidor->nombres??'' }}" id="txt_nombres" name="nombres" class="form-control" required>
                                    <label for="txt_nombres">Nombres:<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="md-form md-outline my-0">
                                    <input type="text" value="{{ $consumidor->direccion??'SALCEDO' }}" id="txt_direccion" name="direccion" class="form-control" required>
                                    <label for="txt_direccion">Dirección:<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="md-form md-outline my-0">
                                    <input type="text" value="{{ $consumidor->telefono??'' }}" id="txt_telefono" name="telefono" class="form-control">
                                    <label for="txt_telefono">Teléfono:</label>
                                </div>
                            </div>
                        </div>
                       
                        
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Detalle</th>
                                    <th scope="col">V.unitario</th>
                                    <th scope="col">V.total</th>
                                </tr>
                                </thead>
                                <tbody id="detalle_factura">
                                
                                
                                </tbody>
                                <tfoot>
                                    <tr>
                                        
                                        <td colspan="2">
                                            <p class="my-0"><strong>FORMA DE PAGO:</strong></p>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="check_efectivo" name="forma_pago" value="Efectivo" checked>
                                                <label class="custom-control-label" for="check_efectivo">Efectivo</label>
                                            </div>
                                            
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="check_cheque" name="forma_pago" value="Cheque">
                                                <label class="custom-control-label" for="check_cheque">Cheque</label>
                                            </div>
            
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="check_dinero_electronico" name="forma_pago" value="Dinero Electrónico">
                                                <label class="custom-control-label" for="check_dinero_electronico">Dinero electrónico</label>
                                            </div>
            
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="check_tarjeta_c_d" name="forma_pago" value="Tarjeta de crédito/débito">
                                                <label class="custom-control-label" for="check_tarjeta_c_d">Tarjeta de crédito/débito</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="check_otros" name="forma_pago" value="Otros">
                                                <label class="custom-control-label" for="check_otros">Otros</label>
                                            </div>
            
                                        </td>
                                        <td colspan="3">
                                            
                                            <p>
                                                SUB TOTAL {{ $iva }}% <strong class="float-right" id="sub_total_factura">0.00</strong><br>
                                                SUB TOTAL 0% <strong class="float-right">0.00</strong><br>
                                                DESCUENTO <strong class="float-right">0.00</strong><br>
                                                SUB TOTAL <strong class="float-right">0.00</strong><br>
                                                IVA {{ $iva }}% <strong class="float-right" id="iva_factura">0.00</strong><br>
                                                VALOR TOTAL <strong class="float-right" id="total_factura">0.00</strong><br>
                                            </p>
                                            
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="md-form form-sm">
                            <textarea id="textarea-char-counter" class="form-control form-control-sm md-textarea" name="observacion" cols="1" rows="1"></textarea>
                            <label for="textarea-char-counter">Observación de la factura..</label>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-dark btn-block btn-lg" type="submit">
                            <i class="fas fa-dollar-sign fa-2x"></i> Procesar venta
                        </button>
                    </div>
                </div>
            </form>

        </div>
</div>



  
  <!-- Full Height Modal Right -->
  <div class="modal fade left" id="modalListadoClientes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-full-height modal-left modal-lg " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title w-100" id="myModalLabel">Selecionar cliente</h4>
         
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                {!! $udt->html()->table() !!}
            </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Full Height Modal Right -->
  



  
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
{{-- moeny --}}
<link rel="stylesheet" href="{{ asset('js/jquery.numbox-1.3.0/jquery.numbox-1.3.0.css') }}">
<script src="{{ asset('js/jquery.numbox-1.3.0/jquery.numbox-1.3.0.min.js') }}"></script>
{{-- block --}}
<script src="{{ asset('js/jquery.blockUI.js') }}"></script>
{{-- imager --}}
<link rel="stylesheet" href="{{ asset('js/Magnific-Popup/dist/magnific-popup.css') }}">
<script src="{{ asset('js/Magnific-Popup/dist/jquery.magnific-popup.min.js') }}"></script>

@endpush

@prepend('linksPie')
    <script>
        $('#ventas').addClass('active');
        $('#facturas').addClass('active');
        $('table').on('draw.dt', function() {
            $('.test-popup-link').magnificPopup({
                type: 'image'
            });
        });


        // selecionar cliente de modal
        function selecionarCliente(arg){
            $('#modalListadoClientes').modal('hide');
            $('#txt_apellidos').val($(arg).data('apellidos'));
            $('#txt_nombres').val($(arg).data('nombres'));
            $('#txt_identificacion').val($(arg).data('identificacion'));
            $('#txt_direccion').val($(arg).data('direccion'));
            $('#txt_telefono').val($(arg).data('telefono'));
        }

        // selecionar producto de tabla
        function selecionarProducto(arg){

            var id_pro=$(arg).data('id');


            if($('#fila_'+id_pro).length){
                $.notify("Producto ya está agregado","info");
            }else{

                if($('.v_total_fila').length<=9){
                    var caja_producto='<input type="hidden" name="producto['+id_pro+']" value="'+id_pro+'" required>';
                    var caja_detalle='<input type="hidden" name="detalle['+id_pro+']"  value="'+$(arg).data('detalle')+'" required>';
                    var caja_cantidad='<input type="number" name="cantidad['+id_pro+']" onkeyup="cambiarCantidad(this);" data-id="'+id_pro+'" id="txt_cantidad_'+id_pro+'" value="1" class="form-control form-control-sm">';
                    var caja_v_unitario='<input type="number" name="valor_unitario['+id_pro+']" onkeyup="cambiarValorUnitario(this);" data-id="'+id_pro+'" id="txt_v_unitario_'+id_pro+'" value="'+$(arg).data('precio')+'" class="form-control form-control-sm">';

                    var fila='<tr class="filax" id="fila_'+id_pro+'">'+
                            '<td><button type="button" class="btn btn-danger btn-sm" onclick="quitarFila(this);" data-id="'+id_pro+'">x</button></td>'+
                            '<th scope="row">'+caja_producto+caja_cantidad+'</th>'+
                            '<td>'+caja_detalle+ $(arg).data('detalle')+'</td>'+
                            '<td>'+caja_v_unitario+'</td>'+
                            '<td class="v_total_fila" id="v_total_fila_'+id_pro+'">'+($(arg).data('precio')*1)+'</td>'+
                        '</tr>';

                    $('#detalle_factura').append(fila);
                    $('#txt_cantidad_'+id_pro ).NumBox({symbol: '',max:$(arg).data('cantidad')});
                    $('#txt_v_unitario_'+id_pro ).NumBox({symbol: ''});

                    calcularSubTotal();
                }else{
                    $.notify("No puede facturar mas de 10 items","info");
                }

                
            }
        }



        function quitarFila(arg){
            $('#fila_'+$(arg).data('id')).remove();
            calcularSubTotal();
        }


        function cambiarCantidad(arg){
            var valor=$(arg).val();
            var id=$(arg).data('id');
            var cantidad=$('#txt_v_unitario_'+id).val();
            
            $('#v_total_fila_'+id).html((valor*cantidad).toFixed(2))


            calcularSubTotal();
        }


        function cambiarValorUnitario(arg){
            var valor=$(arg).val();
            var id=$(arg).data('id');
            var cantidad=$('#txt_cantidad_'+id).val();
            
            $('#v_total_fila_'+id).html((valor*cantidad).toFixed(2))

            calcularSubTotal();
        }

        

        function calcularSubTotal(){
            total=0;
            $('.v_total_fila').each(function(i,row) {
                total+=parseFloat($(row).text());
            });

            valor_total=total.toFixed(2);
            subtotal = (valor_total / (({{ $iva }} / 100) + 1)).toFixed(2);
            iva = (valor_total-subtotal).toFixed(2);

            $('#sub_total_factura').html(subtotal);
            $('#iva_factura').html(iva);
            $('#total_factura').html(valor_total);
            
        }

       

        $('#formFactura').submit(    function(e){     
            e.preventDefault();
            var form = $(this);
           
            $.confirm({
				title: "Confirmar venta",
				content: $('#txt_cliente').text()+'<br>Total: '+$('#total_factura').text(),
				theme: 'modern',
				type:'dark',
				icon:'fas fa-dollar-sign',
				closeIcon:true,
				buttons: {
					confirmar: {
                        text:'Confirmar [enter]',
                        keys: ['enter'],
                        action:function(){
                            $.blockUI({ message: '<i class="fas fa-spinner fa-spin"></i> Solo un momento ...' });
                            $.ajax({
                                url: form.attr("action"),
                                type: form.attr("method"),
                                data: form.serialize(),
                                success:function(data){
                                                                      
                                    if(data.success){
                                            
                                        var botonImprimir='<button type="button" class="btn btn-danger" onclick="botonImprimirFactura(this);" data-url="'+data.url+'" data-titulo="'+data.titulo+'"><i class="fas fa-print fa-2x"></i> '+data.titulo+'</button>';
                                        
                                        $("#contenedorBotonesImprimir").html('').append(botonImprimir);
                                        $('#ultimaFactura').html(data.ultimaFactura);
                                        abrirModalFactura(data.url,data.titulo);
                                        $("#alertaErrores").hide();
                                        $("#listaErrores").html('');
                                        $('#detalle_factura').html('');
                                        $("#formFactura")[0].reset();
                                        $('#ventas-productos-table').DataTable().ajax.reload();
                                    }

                                    if(data.error){
                                        $("#listaErrores").html('');
                                        $("#alertaErrores").show();
                                        $("#listaErrores").append('<strong>'+data.error+'</strong>');
                                    }

                                    
                                },
                                complete:function(){
                                    $.unblockUI();
                                },
                                error: function (data,err) {
                                    console.log(err)
                                    
                                    $("#listaErrores").html('');
                                    $("#alertaErrores").show();
                                    var errores='';
                                    var datAux = data.responseJSON;
                                    $.each(datAux.errors, function() {
                                        $.each(this, function(k, v) {
                                            errores+='<li class="font-weight-semibold">' + v + '</li>';
                                        });
                                    });

                                    if (errores) {
                                        $("#listaErrores").append(errores);
                                    }else if (err) {
                                        $("#listaErrores").append('<strong>'+err+'</strong>');
                                    }
                                }
                            });
                        }

                    }
				}
			});

            });
        

        function botonImprimirFactura(arg){
            abrirModalFactura($(arg).data('url'),$(arg).data('titulo'));
        }

        function cerrarAlertErrorres(){
            $('#alertaErrores').hide();
        }


    function abrirModalFactura(url,titulo){
        $('#modalFactura').modal('show');
        $('#contenedorFactura').attr('src',url);
        $('#tituloFactura').html(titulo);
    }

    function buscarCliente(arg){
        var identificacion=$(arg).val();
        $.post( "{{ route('buscarCliente') }}", { identificacion: identificacion})
        .done(function( data ) {
            if(data.id){
                $('#txt_apellidos').val(data.apellidos);
                $('#txt_nombres').val(data.nombres);
                $('#txt_direccion').val(data.direccion);
                $('#txt_telefono').val(data.telefono);
            }else{
                $('#txt_apellidos').val('');
                $('#txt_nombres').val('');
                $('#txt_direccion').val('');
                $('#txt_telefono').val('');
            }
        });
    }
            
    </script>
    
    
    
    {!! $udt->html()->scripts() !!} 
    {!! $pdt->html()->scripts() !!} 





@endprepend


@endsection
