@extends('layouts.nav')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <?php
        $nombre = Auth::user()->name;
        ?>
        <div>
            <div class="home-cabecera">
                <img id="read" src="{{asset('img/reading.svg')}}"/>
                <h3>¡Te damos la bienvenida, {{ $nombre }}!</h3>
            </div>
            <h2 class="t2">¿Qué quieres hacer hoy?</h2>
        </div>
        <div class="row acciones">
            <div class="col">
                <div class="card text-center h-100">
                    <img src="{{asset('img/library.jpg')}}" class="card-img-top">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Explorar</h5>
                        <div class="h-50 d-flex align-items-center justify-content-center py-4">
                            Explora las categorías y descubre tu próxima lectura.
                            ¿A qué esperas?
                        </div>
                        <button type="button" onclick="window.location ='{{ url("explorar")}}'" class="btn btn-dark boton2 mt-auto mx-auto">¡Llévame!</button>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-center h-80">
                    <img src="{{asset('img/sell.jpg')}}" class="card-img-top">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Vender</h5>
                        <div class="h-50 d-flex align-items-center justify-content-center py-4">
                            Si crees que alguno de tus ejemplares se merece una segunda vida, no esperes más y súbelo para que otros usuarios puedan encontrarlo.
                        </div>
                        <button type="button" onclick="window.location ='{{ url("nuevolibro")}}'" class="btn btn-dark boton2 mt-auto mx-auto">¡Llévame!</button>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-center h-100">
                    <img src="{{asset('img/list.jpg')}}" class="card-img-top">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Revisar tu historial</h5>
                        <div class="h-50 d-flex align-items-center justify-content-center py-4">
                            Revisa tu historial de compras y ventas.
                        </div>
                        <button type="button" class="btn btn-dark boton2 mt-auto mx-auto">¡Llévame!</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('head')
<!-- Push al layout de css personalizado -->
<link href="{{ asset('css/home.css') }}" rel="stylesheet" type="text/css" >
@endpush

@endsection