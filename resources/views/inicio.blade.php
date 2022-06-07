@extends('layouts.nav')

@section('content')
<div class="container">
    <div class="c-bienvenida">
        <div class="bienvenida-titulo">
            BookMyBook
        </div>
        <div class="bienvenida-subtitulo">
            Mercado virtual de libros de segunda mano
        </div>
    </div>
    
    <div class="container">
        <h2>¿Por qué BookMyBook?</h2>
    </div>
    <div class="tarjetas">
        <div class="card" style="width: 18rem;">
            <img src="/img/open-book.png" class="card-img-top tarjeta-img" alt="...">
            <div class="card-body">
                <h5 class="card-title tarjeta-title">Descubrirás</h5>
                <p class="card-text">Descubrirás montones de libros que en otros lugares no podrás encontrar. En BookMyBook, nada pasa de moda.</p>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <img src="/img/piggy-bank.png" class="card-img-top tarjeta-img" alt="...">
            <div class="card-body">
                <h5 class="card-title tarjeta-title">Ahorrarás</h5>
                <p class="card-text">Queremos hacer de la lectura un placer que esté al alcance de todos. Un nuevo libro no tiene por qué ser caro. Además, podrás ganar dinero vendiendo tus antiguos libros.</p>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <img src="/img/world.png" class="card-img-top tarjeta-img" alt="...">
            <div class="card-body">
                <h5 class="card-title tarjeta-title">Ayudarás</h5>
                <p class="card-text">Reutilizando libros contribuirás a que se generen menos copias, por lo que también se reducirá la huella de carbono.</p>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <img src="/img/smiling-face.png" class="card-img-top tarjeta-img" alt="...">
            <div class="card-body">
                <h5 class="card-title tarjeta-title">Darás otra oportunidad</h5>
                <p class="card-text">Seguro que ese libro que tienes en olvidado en la estantería se merece una segunda oportunidad. No esperes más y ponlo a la venta.</p>
            </div>
        </div>
    </div>
    
    <div class="acciones">
        <p><a href="/register">Regístrate</a> o <a href="/login">inicia sesión</a> para comenzar.</p>
    </div>
</div>

<footer>
    Mónica Vaamonde Suárez, 2022
</footer>
@endsection