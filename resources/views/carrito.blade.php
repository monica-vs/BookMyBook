@extends('layouts.nav')

@section('content')
<?php

use App\Models\UserInfo;

$user_id = Auth::user()->id;
$userinfo = UserInfo::find($user_id);
?>
<div class="container">
    <h1>Carrito</h1>
    <div id="cuenta" hidden="hidden">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID de producto</th>
                    <th scope="col">Título</th>
                    <th scope="col">Autor</th>
                    <th scope="col">Precio</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody id="cuenta-table-body">

            </tbody>
        </table>

        <div id="d-precio">
            <p id="precio"></p>
            <button class="btn btn-success" data-bs-toggle="offcanvas" data-bs-target="#offcanvasPedido">Realizar pedido</button>
            <button class="btn btn-secondary">Seguir comprando</button>
        </div>
    </div>
    <div id="sin-cuenta" hidden="hidden">
        <div id="carrito-alerta" class="alert alert-secondary" role="alert">Tu carrito está vacío. Añade algún libro para proceder a realizar un pedido.</div>
    </div>

    <div class="offcanvas offcanvas-bottom h-75 w-50 m-auto" tabindex="-1" id="offcanvasPedido" aria-labelledby="offcanvasPedidoLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasPedidoLabel">Realizar pedido</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="my-2">
                Comprueba que tus datos son correctos.
            </div>
            <div class="card w-50 mb-3">
                @if($userinfo == null)
                <div class="card-body">
                    Por favor, añade una dirección desde <a href="/perfil">tu perfil</a> antes de continuar.
                </div>
                @else
                <div class="card-body">
                    Dirección: {{$userinfo->direccion}} <br>
                    Teléfono: {{$userinfo->telefono}}
                </div>
                @endif
            </div>
            @if($userinfo != null)
            <div class="my-2">
                Añade un método de pago.
            </div>
            <div class="card w-50  mb-3">
                <div class="card-header">Tarjeta de crédito o débito</div>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="addon-titular">Titular</span>
                        <input type="text" class="form-control" placeholder="Titular de la tarjeta" aria-label="Titular" aria-describedby="addon-titular">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="addon-numero">Número</span>
                        <input type="text" class="form-control" placeholder="Número de la tarjeta" aria-label="Numero" aria-describedby="addon-numero">
                    </div>
                    <div class="input-group mb-3 w-50">
                        <span class="input-group-text" id="addon-fecha">Fecha de validez</span>
                        <input type="text" class="form-control" placeholder="MM/AA" aria-label="Fecha" aria-describedby="addon-fecha">
                    </div>
                    <div class="input-group mb-3 w-25">
                        <span class="input-group-text" id="addon-cvc">CVC</span>
                        <input type="text" class="form-control" aria-label="CVC" aria-describedby="addon-cvc">
                    </div>
                </div>
            </div>
            <div>
                <button class="btn btn-success" id="btn-pago">Realizar pago</button>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    //Pasamos número de usuario autenticado al código JavaScript
    let user_id = {!! json_encode($user_id) !!}
    ;
</script>

@push('head')
<!-- Push al layout de css personalizado -->
<link href="{{ asset('css/carrito.css') }}" rel="stylesheet" type="text/css" >
<!-- Push al layout de JavaScript personalizado -->
<script src="{{ asset('js/carrito.js') }}" defer></script>
@endpush

@endsection