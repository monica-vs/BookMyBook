<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css" >
    
    <title>BookMyBook | Inicio</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light sticky-top navegacion">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">BookMyBook</a>
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                        <a href="{{ url('/home') }}">Home</a>
                        <a href="{{ route('login') }}"><button type="button" class="btn btn-outline-light">Iniciar Sesión</button></a>
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline"><button type="button" class="btn btn-outline-light">Registrarse</button></a>
                </div>
    </div>
  </nav>

  <div class="container-fluid banner d-flex justify-content-center align-items-center">
    <h1 class="bienvenida">Un nuevo libro te está esperando</h1>
    
  </div>
    
</body>
</html>