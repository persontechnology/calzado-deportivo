@extends('layouts.app',['title'=>'Bienvenido'])
@section('breadcrumbs', Breadcrumbs::render('home'))
@section('content')
<div style="height: 75vh">
    <div class="flex-center flex-column">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @auth
    <div class="alert alert-success" role="alert">
        Bienvenido, <strong>{{ Auth::user()->email }}</strong>
    </div>
    @endauth
    </div>
  </div>



@push('linksCabeza')

@endpush

@prepend('linksPie')
    <script>
    $('#menuInicio').addClass('active');
    </script>
    
@endprepend

@endsection
