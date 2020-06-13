@extends('layouts.app',['title'=>'Mi perfil'])
@section('breadcrumbs', Breadcrumbs::render('miPerfil',$user))
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Mi perfil
                </div>

                <div class="card-body">
                    <form action="{{ route('actualizarMiPerfil') }}" method="POST">
                        @csrf
                        

                        <div class="md-form md-outline my-1">
                            <input type="text" id="identificacion" name="identificacion" class="form-control @error('identificacion') is-invalid @enderror " value="{{ old('identificacion',$user->identificacion) }}" required>
                            <label for="identificacion">Identificación<i class="text-danger">*</i></label>
                            @error('identificacion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-row">
                            <div class="col">
                                <div class="md-form md-outline my-1">
                                    <input id="apellidos" name="apellidos" class="form-control @error('apellidos') is-invalid @enderror" value="{{ old('apellidos',$user->apellidos) }}"  required  type="text">
                                    <label for="apellidos">Apellidos<i class="text-danger">*</i></label>
                                    @error('apellidos')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="md-form md-outline my-1">
                                    <input id="nombres" name="nombres" class="form-control @error('nombres') is-invalid @enderror" value="{{ old('nombres',$user->nombres) }}" required type="text">
                                    <label for="nombres">Nombres<i class="text-danger">*</i></label>
                                    @error('nombres')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col">
                                <div class="md-form md-outline my-1">
                                    <input id="telefono" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono',$user->telefono) }}"  required  type="number">
                                    <label for="telefono">Teléfono<i class="text-danger">*</i></label>
                                    @error('telefono')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="md-form md-outline my-1">
                                    <input id="direccion" name="direccion" class="form-control @error('direccion') is-invalid @enderror" value="{{ old('direccion',$user->direccion) }}" required type="text">
                                    <label for="direccion">Dirección<i class="text-danger">*</i></label>
                                    @error('direccion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                                             
                        <!--Accordion wrapper-->
                        <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">

                            <!-- Accordion card -->
                            <div class="card">
                        
                                <!-- Card header -->
                                <div class="card-header" role="tab" id="headingOne1">
                                    <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1" aria-expanded="true"
                                    aria-controls="collapseOne1">
                                    <h5 class="mb-0">
                                        Actualizar contraseña <i class="fas fa-angle-down rotate-icon"></i>
                                    </h5>
                                    </a>
                                </div>
                            
                                <!-- Card body -->
                                <div id="collapseOne1" class="collapse" role="tabpanel" aria-labelledby="headingOne1" data-parent="#accordionEx">
                                    <div class="card-body">
                                        
                                        <div class="md-form md-outline my-1">
                                            <input id="password-actual" name="password_actual" class="form-control @error('password_actual') is-invalid @enderror" value="{{ old('password_actual') }}" type="password">
                                            <label for="password-actual">Contraseña actual</label>
                                            @error('password_actual')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                
                                        <div class="md-form md-outline my-1">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                                            <label for="password">Nueva contraseña</label>
                
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>Confirmar nueva contraseña</strong>
                                                </span>
                                            @enderror
                                        </div>
                
                                        <div class="md-form md-outline my-1">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password">
                                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                        </div>
                                    </div>
                                </div>
                        
                            </div>
                            <!-- Accordion card -->

                        
                        </div>
                        <!-- Accordion wrapper -->

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
