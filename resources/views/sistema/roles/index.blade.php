@extends('layouts.app',['title'=>'Roles'])

@section('breadcrumbs', Breadcrumbs::render('roles'))

@section('content')

<div class="container">
    <form action="{{ route('guardarRol') }}" method="post">
        @csrf

       

        <div class="input-group mb-3">
            <input type="text" name="rol" value="{{ old('rol') }}" class="form-control" placeholder="Ingrese nuevo rol.." aria-label="Ingrese nuevo rol.." aria-describedby="basic-addon2" required>
            <div class="input-group-append">
              <button class="btn btn-md btn-primary m-0 px-3 py-2 z-depth-0 waves-effect" type="submit" id="button-addon2">Guardar</button>
            </div>
          </div>

    </form>

    <div class="card card-body">
        <div class="table-responsive">
            {!! $dataTable->table()  !!}
        </div>
    </div>
</div>


@push('linksCabeza')
{{--  datatable  --}}
<link rel="stylesheet" type="text/css" href="{{ asset('js/DataTables/datatables.min.css') }}"/>
<script type="text/javascript" src="{{ asset('js/DataTables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
@endpush

@prepend('linksPie')
    <script>
        $('#menuRolesPermisos').addClass('active');
    </script>
    {!! $dataTable->scripts() !!}
    
@endprepend

@endsection
