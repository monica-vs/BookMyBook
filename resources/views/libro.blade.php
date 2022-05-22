@extends('layouts.nav')

@section('content')

<div class="container">

    <?php
    $lib = json_decode($libro);
    $libro = $lib[0];
    if ($libro->imagen == null) {
        $libro->imagen = asset('img/no-image.png');
    }
    ?>
    
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/explorar">Explorar</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$libro->titulo}}</li>
        </ol>
    </nav>
    
    <script>
        let lib = <?php echo json_encode($lib); ?>;
        let libro = lib[0];
    </script>
    
    <h1>{{$libro->titulo}}</h1>
    
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
                <p id="vendedor">Vendido por </p>
                <a href="#"><i class="fa-solid fa-envelope"></i> Enviar mensaje al vendedor</a>

                <div id="comprar">
                    <button type="button" class="btn btn-success" id="btn-comprar">Comprar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$libro_usuario_id = $libro->usuario_id;
?>
<script>
    //Pasamos número de usuario dueño del libro al código JavaScript
    let lib_usu_id = {!! json_encode($libro_usuario_id) !!}
    ;
</script>

@push('head')
<!-- Push al layout de css personalizado -->
<link href="{{ asset('css/libro.css') }}" rel="stylesheet" type="text/css" >
<!-- Push al layout de JavaScript personalizado -->
<script src="{{ asset('js/libro.js') }}" defer></script>
@endpush

@endsection