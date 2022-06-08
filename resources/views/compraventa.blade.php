@extends('layouts.nav')

@section('content')

<?php
use App\Models\User;
use App\Models\UserInfo;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\Libro;

//Obtenemos el usuario autenticado
$user = Auth::user();

//Pedidos realizados por el usuario autenticado
$pedidos = Pedido::where('usuario_id', '=', $user->id)->get();

//Libros vendidos por el usuario autenticado
$librosvendidos = Libro::whereRaw('usuario_id = ? and disponible = ?', [$user->id, 0])->get();
$pedidos_vendidos = [];

//Obtenemos los id de pedido correspondientes a los libros peiddos del usuario.
//Este usuario tendrá que gestionar dichos pedidos añadiendo un número de envío.
foreach($librosvendidos as $lv){
    $pv = PedidoDetalle::where('libro_id','=',$lv->id)->get();
    if(!in_array($pv[0]->pedido_id, $pedidos_vendidos)){
        $pedidos_vendidos[] = $pv[0]->pedido_id;
    }
}
sort($pedidos_vendidos);
?>

<div class="container">
    <h1>Historial de pedidos</h1>
    <div class='container'>
        <div class="d-flex flex-row c-principal">
            <div class="d-flex flex-column flex-shrink-0 p-3" style="width: 280px;">
                <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
                <span class="fs-4">Gestionar mis pedidos</span>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link active" aria-current="page" id="compras">
                            <svg class="bi me-2" width="16" height="16"></svg>
                            Compras
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-dark" id="ventas">
                            <svg class="bi me-2" width="16" height="16"></svg>
                            Ventas
                        </a>
                </ul>
                <hr>
            </div>

            <div class="c-display">
                <div id="l-compras" class="container">
                    @if(count($pedidos) == 0)
                    <div class="alert alert-secondary" role="alert">
                        Todavía no has realizado ninguna compra.
                    </div>
                    @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Total</th>
                                <th scope="col">Estado de envío</th>
                                <th scope="col">Número de envío</th>
                                <th scope="col">Recibido</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedidos as $pedido)
                            <tr>
                                <th scope="row">{{ $pedido['id'] }}</th>
                                <td>{{date('d/m/Y H:i', strtotime($pedido['fecha']));}}</td>
                                <td>{{ $pedido['total'] }}€</td>
                                <td>
                                    @if($pedido['enviado'] == 0)
                                    <h5><span class="badge bg-secondary">No enviado</span></h5>
                                    @elseif($pedido['enviado'] == 1 && $pedido['recibido'] == 1)
                                    <h5><span class="badge bg-success">Recibido</span></h5>
                                    @else
                                    <h5><span class="badge bg-success">Enviado</span></h5>
                                    @endif
                                </td>
                                <td>
                                    @if($pedido['num_envio'] == null)
                                    <h5><span class="badge bg-secondary">En espera</span></h5>
                                    @else
                                    {{$pedido['num_envio']}}
                                    @endif
                                </td>
                                <td>
                                    @if($pedido['recibido'] == 0 && $pedido['num_envio'] != null)
                                    <form action="" method="post">
                                        <input type="text" value="{{$pedido['id']}}" hidden="hidden" disabled="disabled"/>
                                        <submit type="button" class="btn btn-success" onclick="confirmarRecepcion({{$pedido['id']}})">Recibido</submit>
                                    </form>
                                    @elseif($pedido['recibido'] == 1)
                                    &nbsp;
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>

                <div id="l-ventas" class="container" hidden="hidden">
                    @if(count($librosvendidos) == 0)
                    <div class="alert alert-secondary" role="alert">
                        Todavía no has vendido ningún libro.
                    </div>
                    @else
                    <div class="accordion accordion-flush" id="accordion-ventas">
                        @foreach($pedidos_vendidos as $pvendido)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-heading{{$pvendido}}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#flush-collapse{{$pvendido}}" aria-expanded="false" aria-controls="flush-collapse{{$pvendido}}">
                                    <i class="fa-solid fa-box-open"></i> &nbsp;Pedido #{{$pvendido}}
                                </button>
                            </h2>
                            <div id="flush-collapse{{$pvendido}}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{$pvendido}}" data-bs-parent="#accordion-ventas">
                                <div class="accordion-body">
                                    <?php
                                    $pedido_libro = Pedido::find($pvendido);
                                    $libros_pedido = PedidoDetalle::where('pedido_id','=',$pvendido)->get();
                                    ?>
                                    <h5>Detalles</h5>

                                    <div class="card">
                                        <div class="card-body">
                                            <p>Pedido realizado el día {{date('d/m/Y', strtotime($pedido_libro->fecha));}} a las {{date('H:i', strtotime($pedido_libro->fecha));}}</p>
                                            
                                            <h5>Listado de productos</h5>
                                            <ul class="list-group my-3">
                                                @foreach($libros_pedido as $lp)
                                                <?php
                                                   $libro = Libro::find($lp->libro_id);
                                                ?>
                                                <li class="list-group-item"><i class="fa-solid fa-book"></i> {{$libro->titulo}}, <i>{{$libro->autor}}</i>, {{$libro->precio}}€</li>
                                                @endforeach
                                            </ul>
                                            
                                            @if($pedido_libro->enviado == 0)
                                            <?php
                                            $destinatario = User::find($pedido_libro->usuario_id)->name;
                                            $datos_destinatario = UserInfo::find($pedido_libro->usuario_id);
                                            ?>
                                            <br>
                                                <h5>Datos de envío</h5>
                                                <div class="container p-2 mb-2">
                                                {{$destinatario}}<br>
                                                {{$datos_destinatario->direccion}}<br>
                                                {{$datos_destinatario->telefono}}<br>
                                                </div>
                                            <div class="alert alert-warning" role="alert">
                                                El pedido todavía no se ha enviado. Por favor, introduce el número de seguimiento una vez hayas realizado el envío.
                                            </div>
                                            <br>
                                            <div class="input-group mb-3">
                                                <input type="text" name='num_envio' id='input-envio{{$pedido_libro->id}}' class="form-control" placeholder="Añadir aquí un número de envío" aria-describedby="envio{{$pedido_libro->id}}" oninput="comprobarInput({{$pedido_libro->id}})" required>
                                                <button class="btn btn-outline-secondary" type="button" id="btn-envio{{$pedido_libro->id}}" onclick="anadirNumeroEnvio({{$pedido_libro->id}})">Aceptar</button>
                                            </div>
                                            <p class="error-message" id="error{{$pedido_libro->id}}" hidden="hidden">
                                                El campo no puede estar vacío.
                                            </p>
                                            @else
                                            <div class="container text-center my-5">
                                            <h5><span class="badge bg-success">Enviado</span></h5>
                                            <i class="fa-solid fa-paper-plane"></i>&nbsp;Número de envío: {{$pedido_libro->num_envio}}
                                            </div>
                                            @endif
                                            @if($pedido_libro->recibido == 1)
                                            <div class="container text-center">
                                            <h5><span class="badge bg-success">Recibido</span></h5>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('head')
<!-- Push al layout de css personalizado -->
<link href="{{ asset('css/nuevolibro.css') }}" rel="stylesheet" type="text/css" >
<!-- Push al layout de JavaScript personalizado -->
<script src="{{ asset('js/compraventa.js') }}" defer></script>
@endpush

@endsection