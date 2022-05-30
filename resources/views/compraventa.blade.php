@extends('layouts.nav')

@section('content')

<?php
use App\Models\Pedido;

$user = Auth::user();
$pedidos = Pedido::where('usuario_id','=',$user->id)->get();

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
                                    @else
                                        
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div id="l-ventas" class="container" hidden="hidden">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    Pedido #
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">Info</div>
                            </div>
                        </div>
                    </div>
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