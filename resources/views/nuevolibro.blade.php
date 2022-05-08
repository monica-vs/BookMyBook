@extends('layouts.nav')

@section('content')
<div class='container'>
    <h1>Nuevo libro</h1>

    <div class="card w-50 mx-auto">
        <div class="card-header">Añadir libro</div>
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
</div>


@endsection