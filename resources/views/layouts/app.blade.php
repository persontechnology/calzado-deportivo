<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ ucfirst($title ?? '') }} | {{ config('app.name', 'Clinica-Utc') }}</title>

    <!-- MDB icon -->
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('fontawesome-free-5.12.1-web/css/all.min.css') }}">
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="{{asset('roboto.css')}}">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{ asset('mdb/css/bootstrap.min.css') }}">
    <!-- Material Design Bootstrap -->
    <link rel="stylesheet" href="{{ asset('mdb/css/mdb.min.css') }}">
    <!-- Your custom styles (optional) -->
    <link rel="stylesheet" href="{{ asset('mdb/css/style.css') }}">


    <!-- JQuery -->
    <script type="text/javascript" src="{{ asset('mdb/js/jquery.min.js') }}"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="{{ asset('mdb/js/popper.min.js') }}"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="{{ asset('mdb/js/bootstrap.min.js') }}"></script>

    <!-- notify -->
    <script src="{{ asset('js/notify.min.js') }}"></script>

    <!-- alertify -->
    <link rel="stylesheet" href="{{ asset('js/jquery-confirm-v3.3.4/dist/jquery-confirm.min.css') }}">
    <script src="{{ asset('js/jquery-confirm-v3.3.4/dist/jquery-confirm.min.js') }}"></script>

    <script>
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
    </script>
    
    @stack('linksCabeza')




</head>
<body>
    
    <div id="app">
        
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                        @auth
                        <li class="nav-item" id="menuInicio">
                            <a class="nav-link" href="{{ route('home') }}">Inicio
                                <span class="sr-only">(current)</span>
                              </a>
                        </li>


                        @can('G. Usuarios')
                        
                        <li class="nav-item" id="menuUsuarios">
                            <a class="nav-link" href="{{ route('usuarios')}}">Usuarios</a>
                        </li>

                        @endcan

                        @can('G. Almacén')
                            
                        <li class="nav-item dropdown" id="almacen">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-555" data-toggle="dropdown"
                              aria-haspopup="true" aria-expanded="false">Almacén
                            </a>
                            <div class="dropdown-menu dropdown-secondary" aria-labelledby="navbarDropdownMenuLink-555">
                              <a class="dropdown-item" id="categorias" href="{{ route('categorias') }}">Categorías</a>
                              <a class="dropdown-item" id="productos" href="{{ route('productos') }}">Productos</a>
                            </div>
                        </li>

                        @endcan


                        @can('G. Ventas')
                            
                        <li class="nav-item dropdown" id="ventas">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-556" data-toggle="dropdown"
                              aria-haspopup="true" aria-expanded="false">Ventas
                            </a>
                            <div class="dropdown-menu dropdown-secondary" aria-labelledby="navbarDropdownMenuLink-556">
                              <a class="dropdown-item" id="facturas" href="{{ route('facturas') }}">Facturas</a>
                            </div>
                        </li>

                        <li class="nav-item" id="nuevaFcatura">
                            <a class="nav-link" href="{{ route('nuevaFactura') }}">Nueva factura</a>
                        </li>

                        @endcan

                        @role('Administrador')
                        <li class="nav-item" id="menuRolesPermisos">
                            <a class="nav-link" href="{{ route('roles')}}">Roles y permisos</a>
                        </li>
                        @endrole
                        
                        
                        
                        @endauth

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item" id="menuLogin">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else



                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fas fa-user"></i> {{ Auth::user()->email }} </a>  <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                    <a class="dropdown-item" href="{{ route('miPerfil') }}">
                                        Mi perfil
                                    </a>
                                    
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>

                                    
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            
            @yield('breadcrumbs')

            @if ($errors->any())
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="alert alert-dark alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li><strong>{{ $error }}</strong></li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
                

			@endif

            @foreach (['success', 'warn', 'info', 'error'] as $msg)
                @if(Session::has($msg))
                <script>
                    $.notify("{{ Session::get($msg) }}", "{{ $msg }}");
                </script>
                @endif
            @endforeach


            @yield('content')
        </main>
    </div>



    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="{{ asset('mdb/js/mdb.min.js') }}"></script>

    @stack('linksPie')


    <script>
        $('[data-toggle="tooltip"]').tooltip();
        $('table').on('draw.dt', function() {
			$('[data-toggle="tooltip"]').tooltip();
        });
        
        function eliminar(arg){
			var url=$(arg).data('url');
			var msg=$(arg).data('title');
			$.confirm({
				title: msg,
				content: 'No podra recuperar el contenido',
				theme: 'modern',
				type:'dark',
				icon:'fas fa-trash',
				closeIcon:true,
				buttons: {
					confirmar: function () {
						location.replace(url);
					}
				}
			});
		}
        
    </script>
</body>
</html>
