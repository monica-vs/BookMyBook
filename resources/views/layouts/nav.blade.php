<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <link href="{{ asset('css/fontawesome/css/all.css') }}" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css" >

        <!-- Incluir aqui scripts/estilos de forma dinamica -->
        @stack('head')
    </head>
    <body>
        <?php

        use App\Models\Mensaje;
        use App\Models\Carrito;

        $user = Auth::user();
        if ($user != null) {
            $user_id = Auth::user()->id;
            $unreadmessages = Mensaje::whereRaw('destinatario = ? and leido = 0', [$user_id])->get();
            $itemscarrito = Carrito::where('usuario_id', '=', $user_id)->get();
        }
        ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Eighth navbar example">
            <div class="container">
                @guest
                <a class="navbar-brand" href="{{route('inicio')}}">BookMyBook</a>
                @else
                <a class="navbar-brand" href="{{route('home')}}">BookMyBook</a>
                @endguest
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="col-7">&nbsp;</div>
                <div class="container">
                    @guest
                    <button type="button" onclick="window.location ='{{ url("login") }}'" class="btn btn-light boton">Iniciar sesión</button>
                    <button type="button" onclick="window.location ='{{ url("register")}}'" class="btn btn-light boton">Registrarse</button>
                    @else
                    <button type="button" onclick="window.location ='{{ url("micarrito")}}'" class="btn btn-light boton position-relative">
                        <i class="fa-solid fa-cart-shopping fa-lg"></i>
                        @if(count($itemscarrito) > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                            {{count($itemscarrito)}}
                            <span class="visually-hidden">unread messages</span>
                        </span>
                        @endif
                    </button>
                    <button type="button" onclick="window.location ='{{ url("mensajes")}}'" class="btn btn-light boton position-relative">
                        <i class="fa-solid fa-message fa-lg"></i>
                        @if(count($unreadmessages) > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{count($unreadmessages)}}
                            <span class="visually-hidden">unread messages</span>
                        </span>
                        @endif
                    </button>
                    <button type="button" onclick="window.location ='{{ url("perfil")}}'" class="btn btn-light boton"><i class="fa-solid fa-user fa-lg"></i></button>
                    <button type="button" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" class="btn btn-light boton"><i class="fa-solid fa-right-from-bracket fa-lg"></i></button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    @endguest
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

    </body>
</html>