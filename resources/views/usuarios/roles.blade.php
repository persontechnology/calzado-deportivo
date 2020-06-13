@extends('layouts.app',['title'=>'Asignar roles'])
@section('breadcrumbs', Breadcrumbs::render('asignarRolUsuario',$user))
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Asignar roles
                </div>

                <div class="card-body">
                    <form action="{{ route('actualizarRolesUsuario') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        
                        <label for="">Selecione:</label> <br>

                        @foreach ($roles as $rol)
                        
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input"name="roles[{{ $rol->id }}]"  value="{{ $rol->id }}" {{ $user->hasRole($rol)?'checked':'' }} {{ old('roles.'.$rol->id)==$rol->id ?'checked':'' }} id="rol_{{ $rol->id }}">
                                <label class="custom-control-label" for="rol_{{ $rol->id }}">
                                    {{ $rol->name }}
                                </label>
                            </div>

                        @endforeach

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
    $('#menuUsuarios').addClass('active');
    </script>
@endprepend
@endsection
