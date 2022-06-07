@extends('layouts.nav')

@section('content')

<?php

use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\Libro;

$user = Auth::user();
$pedidos = Pedido::where('usuario_id', '=', $user->id)->get();
$librosvendidos = Libro::whereRaw('usuario_id = ? and disponible = ?', [$user->id, 0])->get();
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
                                <td>{{ $pedido['fecha'] }}</td>
                                <td>{{ $pedido['total'] }}€</td>
                                <td>
                                    @if($pedido['enviado'] == 0)
                                    <h5><span class="badge bg-secondary">No enviado</span></h5>
                                    @else
                                    <h5><span class="badge bg-success">Enviado</span></h5>
                                    @endif
                                </td>
                                <td>
                                    @if($pedido['num_envio'] == null)
                                    <h5><span class="badge bg-secondary">En espera</span></h5>
                                    @else
                                    <h5><span class="badge bg-success">{{$pedido['num_envio']}}</span></h5>
                                    @endif
                                </td>
                                <td>
                                    @if($pedido['recibido'] == 0 && $pedido['num_envio'] != null)
                                    <form action="" method="post">
                                        <input type="text" value="{{$pedido['id']}}" hidden="hidden" disabled="disabled"/>
                                        <submit type="button" class="btn btn-success">Recibido</submit>
                                    </form>
                                    @elseif($pedido['recibido'] == 1)
                                    Sí
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
                        @foreach($librosvendidos as $libro)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-heading{{$libro['id']}}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#flush-collapse{{$libro['id']}}" aria-expanded="false" aria-controls="flush-collapse{{$libro['id']}}">
                                    <i class="fa-solid fa-book"></i> &nbsp; {{$libro['titulo']}}
                                </button>
                            </h2>
                            <div id="flush-collapse{{$libro['id']}}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{$libro['id']}}" data-bs-parent="#accordion-ventas">
                                <div class="accordion-body">
                                    <?php
                                    $p = PedidoDetalle::where('libro_id', '=', $libro['id'])->get();
                                    $pedido_libro = Pedido::find($p[0]->pedido_id);
                                    ?>
                                    <h5>Pedido #{{$pedido_libro->id}}</h5>

                                    <div class="card">
                                        <div class="card-body">
                                            Pedido realizado el día {{date('d/m/Y', strtotime($pedido_libro->fecha));}} a las {{date('H:i', strtotime($pedido_libro->fecha));}} <br><br>
                                            @if($pedido_libro->enviado == 0)
                                            <div class="alert alert-warning" role="alert">
                                                El libro todavía no se ha enviado. Por favor, introduce el número de seguimiento una vez hayas realizado el envío.
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
                                            <h5><span class="badge bg-success">Enviado</span></h5>
                                            <i class="fa-solid fa-paper-plane"></i>&nbsp;Número de envío: {{$libro_pedido->num_envio}}
                                            @endif
                                            @if($pedido_libro->recibido == 1)
                                            <h5><span class="badge bg-success">Recibido</span></h5>
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