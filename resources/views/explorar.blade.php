@extends('layouts.nav')

@section('content')

<div class='container'>
    <h1>Explora los libros disponibles</h1>

    <div class="barra-filtro">
        <div>
            <div class="input-group mb-3">
                <input id="b-texto" type="text" class="form-control" placeholder="Busca por título, autor..." aria-label="Recipient's username" aria-describedby="button-addon2">
                <button class="btn btn-outline-secondary" type="button" id="button-addon2">Buscar</button>
            </div>
        </div>
        <div>
            <select id="b-seleccion" class="form-select" aria-label="Default select example">
                <option value="0" selected>Filtrar por categoría</option>
                <option value="1">Arte y literatura</option>
                <option value="2">Ciencias y tecnología</option>
                <option value="3">Cocina</option>
                <option value="4">Cómics y manga</option>
                <option value="5">Deportes</option>
                <option value="6">Economía</option>
                <option value="7">Fantasía</option>
                <option value="8">Historia</option>
                <option value="9">Humor</option>
                <option value="10">Infantil</option>
                <option value="11">Libros de texto</option>
                <option value="12">Viajes</option>
                <option value="13">Literatura y ficción</option>
                <option value="14">Política</option>
                <option value="15">Religión</option>
                <option value="16">Salud</option>
                <option value="17">Sociedad y ciencias sociales</option>
            </select>
        </div>
    </div>
    <div id="c-load">
        <div id="load"><span class="loader"></span></div>
    </div>
    <div id='libros'>

    </div>


</div>

<?php
$user_id = Auth::user()->id;
?>
<script>
    //Pasamos número de usuario autenticado al código JavaScript
    let user_id = {!! json_encode($user_id) !!}
    ;
</script>

@push('head')
<!-- Push al layout de css personalizado -->
<link href="{{ asset('css/explorar.css') }}" rel="stylesheet" type="text/css" >
<!-- Push al layout de JavaScript personalizado -->
<script src="{{ asset('js/explorar.js') }}" defer></script>
@endpush

@endsection