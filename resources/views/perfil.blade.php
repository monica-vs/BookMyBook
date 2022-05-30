@extends('layouts.nav')

@section('content')

<div class="container">
    <h1>Mi perfil</h1>
    
    @if (session('mensaje'))
    <div class="alert alert-success" role="alert">{{session('mensaje')}}</div>
    @endif
    
    <?php

    use App\Models\User;
    use App\Models\UserInfo;

    $user = Auth::user();
    $userinfo = UserInfo::find($user->id);
    ?>

    <div class="card w-50 mx-auto">
        <div class="card-header">Mis datos</div>
        <div class="card-body">
            <form class="needs-validation" action="{{ url('/users', $user->id)}}" method="post">
                @csrf
                @method('PUT')
                
                <fieldset id="field1" disabled="true">
                    <input type="text" class="form-control" name="nombre" value="{{$user->id}}" required hidden="hidden">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" value="{{$user->name}}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" name="email" value="{{$user->email}}" required>
                </div>
                </fieldset>
                <div class="botones">
                    <input type="submit" class="btn btn-success" value="Guardar" disabled="true" hidden="hidden" id="guardar1" />
                </div>
            </form>
            <button class="btn btn-secondary" id="editar1">Editar</button>
        </div>
    </div>
    <br>
    <div class="card w-50 mx-auto">
        <div class="card-header">Información adicional</div>
        <div class="card-body">
            @if (empty($userinfo))
            <div class="alert alert-warning" role="alert"><b>ATENCIÓN</b><br>Aún no has completado tu información personal.</div>
            <form class="needs-validation" action="{{ url('/userinfo')}}" method="post">
                @csrf
                <fieldset id="field2" disabled="true">
                    <input type="text" class="form-control" name="id" value="{{ $user->id }}" required hidden="hidden">
                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" placeholder="Calle, número, piso, puerta, localidad..." class="form-control" name="direccion" required>
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" placeholder="Escribe un número de teléfono de contacto" class="form-control" name="telefono" required>
                </div>
                </fieldset>
                <div class="botones">
                    <input type="submit" class="btn btn-success" value="Guardar" disabled="true" hidden="hidden" id="guardar2" />
                </div>
            </form>
            @else
            <form class="needs-validation" action="{{ url('/userinfo', $user->id)}}" method="post">
                @csrf
                @method('PUT')
                <fieldset id="field2" disabled="true">
                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" value='{{$userinfo->direccion}}' class="form-control" name="direccion" required>
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" value='{{$userinfo->telefono}}' class="form-control" name="telefono" required>
                </div>
                </fieldset>
                <div class="botones">
                    <input type="submit" class="btn btn-success" value="Guardar" disabled="true" hidden="hidden" id="guardar2" />
                </div>
            </form>
            @endif
            <button class="btn btn-secondary" id="editar2">Editar</button>
        </div>
    </div>
</div>

@push('head')
<!-- Push al layout de css personalizado -->
<!-- <link href="{{ asset('css/explorar.css') }}" rel="stylesheet" type="text/css" > -->
<!-- Push al layout de JavaScript personalizado -->
<script src="{{ asset('js/perfil.js') }}" defer></script>
@endpush

@endsection