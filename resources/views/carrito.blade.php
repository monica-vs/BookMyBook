@extends('layouts.nav')

@section('content')
<?php
use App\Models\User;
use App\Models\UserInfo;
use App\Models\Libro;
use App\Models\Carrito;

$user_id = Auth::user()->id;
$userinfo = UserInfo::find($user_id);

//Obtenemos los items del carrito del usuario
$carrito = Carrito::where('usuario_id', '=', $user_id)->get();

//Por cada vendedor se realizará un pedido, así que comprobamos cuántos vendedores hay en el carrito
$vendedores = [];

//Obtenemos los ids de los items del carrito para luego eliminarlos, tras hacer el pedido
$ids_carrito = [];

foreach ($carrito as $c) {
    $libro = Libro::find($c->libro_id);
    if (!in_array($libro->usuario_id, $vendedores)) {
        $vendedores[] = $libro->usuario_id;
    }
    $ids_carrito[] = $c->id;
}

//Variable que almacena el número de subpedidos
$n_pedido = 0;

//Variable que almacena el precio total del pedido completo
$total_pedido = 0;

//Variable que almacena subtotales
$subtotal = 0;

//Array de subtotales
$subtotales = [];
?>
<div class="container">
    <h1>Carrito</h1>
    <br><br>
    @if(count($carrito) != 0)
    <div>
        @foreach($vendedores as $vendedor)
        <?php $n_pedido++; $subtotal = 0; $nombre_vendedor = User::find($vendedor)->name;?>
        <h3>Pedido {{$n_pedido}}</h3>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID de producto</th>
                    <th scope="col">Título</th>
                    <th scope="col">Autor</th>
                    <th scope="col">Precio</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody id="cuenta-table-body">
                @foreach($carrito as $item)
                <?php $libro = Libro::find($item->libro_id);?>
                @if($libro->usuario_id == $vendedor)
                <?php $subtotal += $libro->precio ?>
                <tr>
                    <td><span class="idproducto{{$n_pedido}}">{{$libro->id}}</span></td>
                    <td><a href="/libro/{{$libro->id}}">{{$libro->titulo}}</a></td>
                    <td>{{$libro->autor}}</td>
                    <td>{{$libro->precio}}€</td>
                    <td><button type="button" class="btn btn-danger" onclick="eliminar_item({{$item->id}})">Eliminar</button></td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
        <p class="text-end"><b>Subtotal: {{number_format($subtotal, 2)}}€</b><br>Vendido y enviado por {{$nombre_vendedor}}</p>
        <br><br>
        <?php $total_pedido += $subtotal; $subtotales[] = $subtotal;?>
        @endforeach
        @if($n_pedido > 1)
        <p>* Este pedido incluye {{$n_pedido}} subpedidos, cada uno gestionado por un vendedor distinto.</p>
        @endif
        <p class="text-center fs-4 mt-5"><b>Total a pagar: {{number_format($total_pedido,2)}}€</b></p>
        <div id="d-precio">
            <p id="precio"></p>
            <button class="btn btn-success" data-bs-toggle="offcanvas" data-bs-target="#offcanvasPedido">Realizar pedido/s</button>
            <button class="btn btn-secondary" onclick="location.href = '/explorar';">Seguir comprando</button>
        </div>
    </div>

    @else
    <div id="sin-cuenta">
        <div id="carrito-alerta" class="alert alert-secondary" role="alert">Tu carrito está vacío. Añade algún libro para proceder a realizar un pedido.</div>
    </div>
    @endif
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
                <button class="btn btn-success" id="btn-pago" onclick="pagar()">Realizar pago</button>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    //Pasamos número de usuario autenticado al código JavaScript
    let user_id = {!! json_encode($user_id) !!}
    ;
    //Pasamos los subtotales de los pedidos a JavaScript
    let subtotales = {!! json_encode($subtotales) !!};
    //Pasamos los ids de carrito para borrarlos tras hacer el pedido
    let ids_carrito = {!! json_encode($ids_carrito) !!};
</script>

@push('head')
<!-- Push al layout de css personalizado -->
<link href="{{ asset('css/carrito.css') }}" rel="stylesheet" type="text/css" >
<!-- Push al layout de JavaScript personalizado -->
<script src="{{ asset('js/carrito.js') }}" defer></script>
@endpush

@endsection