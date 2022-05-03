@extends('layouts.nav')

@section('content')

<div class="container">
    
    <?php
    $lib = json_decode($libro);
    
    echo '<h1>'.$lib[0]->titulo.'</h1>';
    
    var_dump($lib);
    ?>
</div>

@endsection