@extends('layouts.app',['title'=>'Editar Categoría'])
@section('breadcrumbs', Breadcrumbs::render('editarCategoria',$cat))
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Editar categoría
                </div>

                <div class="card-body">
                    <form action="{{ route('actualizarCategoria') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $cat->id }}">
                        <div class="md-form md-outline my-1">
                            <input type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror " value="{{ old('nombre',$cat->nombre) }}" required>
                            <label for="nombre">Nombre<i class="text-danger">*</i></label>
                            @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="md-form md-outline my-1">
                            <input type="text" id="detalle" name="detalle" class="form-control @error('detalle') is-invalid @enderror " value="{{ old('detalle',$cat->detalle) }}">
                            <label for="detalle">Detalle</label>
                            @error('detalle')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>



                        <!-- Sign up button -->
                        <button class="btn btn-elegant my-2 btn-block" type="submit">Guardar</button>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@prepend('linksPie')
    <script>
    $('#almacen').addClass('active');
    $('#categorias').addClass('active');
    </script>
@endprepend
@endsection
