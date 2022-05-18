@extends('layouts.nav')

@section('content')
<div class='container'>
    <div class="d-flex flex-row c-principal">
        <div class="d-flex flex-column flex-shrink-0 p-3" style="width: 280px;">
            <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
            <span class="fs-4">Gestionar mis libros</span>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link active" aria-current="page" id="anadir-libro">
                        <svg class="bi me-2" width="16" height="16"></svg>
                        Añadir libro
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link link-dark" id="mis-libros">
                        <svg class="bi me-2" width="16" height="16"></svg>
                        Mis libros
                    </a>
            </ul>
            <hr>
        </div>

        <div class="c-display">
            <div id="f-libro" class="card mx-auto w-100">
                <div class="card-header">Datos del libro</div>
                <div class="card-body">
                    <form class="needs-validation" action="{{ url('/libros')}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="ISBN" class="form-label">ISBN</label>
                            <input type="text" class="form-control" name="ISBN" required>
                        </div>
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" name="titulo" required>
                        </div>
                        <div class="mb-3">
                            <label for="autor" class="form-label">Autor</label>
                            <input type="text" class="form-control" name="autor" required>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="text" class="form-control w-50" name="precio" required>
                        </div>
                        <div class="mb-3">
                            <label for="imagen" class="form-label">URL de imagen</label>
                            <input type="text" class="form-control" name="imagen" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Categoría</label>
                            <select class="form-select" name="categoria" required>
                                <option selected disabled value="">Elije una categoría...</option>
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
                        <div class="col-12 mt-2">
                            <input class="btn btn-primary" type="submit" value="Añadir">
                        </div>
                    </form>
                </div>
            </div>

            <div id="l-libros" class="table-responsive" hidden="hidden">
                <div class="alert alert-secondary" role="alert">
                    Aquí podrás consultar y gestionar los libros que tienes a la venta en este momento.
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ISBN</th>
                            <th scope="col">Título</th>
                            <th scope="col">Autor</th>
                            <th scope="col">Categoría</th>
                            <th scope="col">Precio</th>
                            <th scope="col"> </th>
                        </tr>
                    </thead>
                    <tbody id="c-table">

                    </tbody>
                </table>
            </div>
        </div>
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
<link href="{{ asset('css/nuevolibro.css') }}" rel="stylesheet" type="text/css" >
<!-- Push al layout de JavaScript personalizado -->
<script src="{{ asset('js/nuevolibro.js') }}" defer></script>
@endpush

@endsection