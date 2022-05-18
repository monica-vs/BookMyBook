@extends('layouts.nav')

@section('content')

<div class="container">
    <?php
    $lib = json_decode($libro);
    $libro = $lib[0];
    if($libro->imagen == null){
        $libro->imagen = asset('img/no-image.png');
    }
    echo '<h1>' . $libro->titulo . '</h1>';
    ?>

    <script>
        let lib = <?php echo json_encode($lib); ?>;
        let libro = lib[0];
    </script>

    <div class="libro-detalles">
        <div class="libro-imagen">
            <img src="{{$libro->imagen}}" alt="Imagen de libro" id="imagen-libro"/>
        </div>
        <div class="libro-datos">
            <div id="datos">
                <p><b>ISBN:</b> {{$libro->isbn}}</p>
                <p><b>Autor:</b> {{$libro->autor}}</p>
                <p><b>Categoría:</b> {{$libro->categoria}}</p>
            </div>
            <div id="precio">
                <div id="fondo-precio">
                {{$libro->precio}}€
                </div>
            </div>
            <div id="compra">
                <p>Vendido por {{$libro->usuario_id}}</p>
                <a href="#">Enviar mensaje al vendedor</a>
                <div id="boton-comprar">
                    <button>Comprar</button>
                </div>
            </div>
        </div>
    </div>
</div>


@push('head')
<!-- Push al layout de css personalizado -->
<link href="{{ asset('css/libro.css') }}" rel="stylesheet" type="text/css" >
<!-- Push al layout de JavaScript personalizado -->
<script src="{{ asset('js/libro.js') }}" defer></script>
@endpush

@endsection