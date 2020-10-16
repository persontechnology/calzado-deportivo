@extends('layouts.app',['title'=>'Productos'])
@section('breadcrumbs', Breadcrumbs::render('productos'))
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Productos
                    <a  href="{{ route('nuevoProducto') }}" class="float-right" data-toggle="tooltip" data-placement="top" title="Ingresar nuevo producto">
                        <i class="fas fa-plus"></i>
                    </a>
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

@push('linksCabeza')
{{--  datatable  --}}
<link rel="stylesheet" type="text/css" href="{{ asset('js/DataTables/datatables.min.css') }}"/>
<script type="text/javascript" src="{{ asset('js/DataTables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>

{{-- imager --}}
<link rel="stylesheet" href="{{ asset('js/Magnific-Popup/dist/magnific-popup.css') }}">
<script src="{{ asset('js/Magnific-Popup/dist/jquery.magnific-popup.min.js') }}"></script>
{{-- block --}}
<script src="{{ asset('js/jquery.blockUI.js') }}"></script>

@endpush

@prepend('linksPie')
    <script>
        $('#almacen').addClass('active');
        $('#productos').addClass('active');
        $('table').on('draw.dt', function() {
            $('.test-popup-link').magnificPopup({
                type: 'image'
            });
        });

        function duplicar(arg){
            var url=$(arg).data('url');
			var msg=$(arg).data('id');
			$.confirm({
				title: "Duplicar producto",
				content: 'Se realiza una copia con los valores actuales del producto',
				theme: 'modern',
				type:'dark',
				icon:'fas fa-info',
				closeIcon:true,
				buttons: {
					confirmar: function () {
                        $.blockUI({ message: '<i class="fas fa-spinner fa-spin"></i> Solo un momento ...' });
                        $.post( url, { id:msg  })
                        .done(function( data ) {
                            if(data.url){
                                location.replace(data.url); 
                            }

                            if(data.error){
                                console.log(data.error)
                            }
                            
                        })
                        .fail(function(err) {
                            console.log("Ocurrrio un error vuelva intentar")
                        })
                        .always(function() {
                            $.unblockUI();
                        });
					}
				}
			});
        }

    </script>
    {!! $dataTable->scripts() !!}
@endprepend


@endsection
