@extends('layouts.nav')

@section('content')

<div class='container'>
    <h1>Explora los libros disponibles</h1>

    <div id='libros'>

    </div>

    
</div>

@push('head')
<!-- Push al layout de css personalizado -->
<link href="{{ asset('css/explorar.css') }}" rel="stylesheet" type="text/css" >
<!-- Push al layout de JavaScript personalizado -->
<script src="{{ asset('js/explorar.js') }}" defer></script>
@endpush

@endsection