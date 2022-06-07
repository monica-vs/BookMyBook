@extends('layouts.nav')

@section('content')
<?php

use App\Models\Mensaje;
use App\Models\User;

$user_id = Auth::user()->id;
$recibidos = Mensaje::where('destinatario', '=', $user_id)->orderBy('id', 'DESC')->get();
$enviados = Mensaje::where('remitente', '=', $user_id)->orderBy('id', 'DESC')->get();
?>
<div class="container">
    <h1>Mensajes</h1>

    <div class="d-flex align-items-start my-4">
        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-entrada" type="button" role="tab" aria-controls="v-pills-entrada" aria-selected="true">Bandeja de entrada</button>
            <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-enviados" type="button" role="tab" aria-controls="v-pills-enviados" aria-selected="false">Enviados</button>
        </div>
        <div class="tab-content w-75" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pills-entrada" role="tabpanel" aria-labelledby="v-pills-entrada-tab" tabindex="0">
                @if(count($recibidos) == 0)
                <div class="alert alert-secondary" role="alert">
                   No hay mensajes para mostrar.
                </div>
                @endif
                <div class="accordion" id="accordionExample">
                    @foreach($recibidos as $recibido)
                    <?php
                    $remitente = User::find($recibido->remitente);
                    $nombre_remitente = $remitente->name;
                    ?>
                    <div class="accordion-item">
                        @if($recibido->leido == 0)
                        <h2 class="accordion-header bg-primary" id="heading{{$recibido->id}}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$recibido->id}}" aria-expanded="false" aria-controls="collapse{{$recibido->id}}">
                                <h5><span class="badge bg-primary">No leído</span> </h5>&nbsp;&nbsp;<b>De {{$nombre_remitente}}</b>
                            </button>
                        </h2>
                        @else
                        <h2 class="accordion-header bg-secondary" id="heading{{$recibido->id}}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$recibido->id}}" aria-expanded="false" aria-controls="collapse{{$recibido->id}}">
                                <h5><span class="badge bg-secondary">Leído</span> </h5>&nbsp;&nbsp;<b>De {{$nombre_remitente}}</b>
                            </button>
                        </h2>
                        @endif
                        <div id="collapse{{$recibido->id}}" class="accordion-collapse collapse" aria-labelledby="heading{{$recibido->id}}" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="cuerpo-mensaje">
                                    <div class="texto-mensaje">
                                        {{$recibido->mensaje}}
                                    </div>
                                    <div class="fecha-mensaje">
                                        {{date('d/m/Y H:i', strtotime($recibido->fecha_hora));}}
                                    </div>
                                </div>    
                            </div>
                            @if($recibido->leido == 0)
                            <div class="marcar-leido">
                                <button type="button" class="btn btn-outline-secondary" onclick="marcarLeido({{$recibido->id}})">
                                    Marcar como leído
                                </button>
                            </div>
                            @endif
                            <div class="respuesta">
                                <h5>Responder al mensaje</h5>
                                <form action="{{ url('/mensaje')}}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <textarea class="form-control" name="mensaje" maxlength="150" id="mensaje" placeholder="Escribe aquí tu mensaje..." cols="40" rows="5"></textarea>
                                    </div>
                                    <input type="hidden" name="remitente" class="form-control" id="rem" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="destinatario" class="form-control" id="des" value="{{$recibido->remitente}}">
                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade" id="v-pills-enviados" role="tabpanel" aria-labelledby="v-pills-enviados-tab" tabindex="0">
                @if(count($enviados) == 0)
                <div class="alert alert-secondary" role="alert">
                   No hay mensajes para mostrar.
                </div>
                @endif
                <div class="accordion" id="accordionExample2">
                    @foreach($enviados as $enviado)
                    <?php
                    $destinatario = User::find($enviado->destinatario);
                    $nombre_destinatario = $destinatario->name;
                    ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header bg-secondary" id="heading{{$enviado->id}}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$enviado->id}}" aria-expanded="false" aria-controls="collapse{{$enviado->id}}">
                                Para {{$nombre_destinatario}}
                            </button>
                        </h2>
                        <div id="collapse{{$enviado->id}}" class="accordion-collapse collapse" aria-labelledby="heading{{$enviado->id}}" data-bs-parent="#accordionExample2">
                            <div class="accordion-body">
                                <div class="cuerpo-mensaje">
                                    <div class="texto-mensaje">
                                        {{$enviado->mensaje}}
                                    </div>
                                    <div class="fecha-mensaje">
                                        {{date('d/m/Y H:i', strtotime($enviado->fecha_hora));}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('head')
<!-- Push al layout de css personalizado -->
<link href="{{ asset('css/mensajes.css') }}" rel="stylesheet" type="text/css" >
<!-- Push al layout de JavaScript personalizado -->
<script src="{{ asset('js/mensajes.js') }}" defer></script>
@endpush

@endsection