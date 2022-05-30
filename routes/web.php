<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PedidoDetalleController;
use App\Models\Libro;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('inicio');
})->middleware('guest')->name('inicio');

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/nuevolibro', function () {
    return view('nuevolibro');
})->middleware('auth');

Route::get('/explorar', function () {
    return view('explorar');
})->middleware('auth');

Route::get('/perfil', function () {
    return view('perfil');
})->middleware('auth')->name('perfil');

Route::get('/explorar', function () {
    return view('explorar');
})->middleware('auth');

Route::get('/micarrito', function () {
    return view('carrito');
})->middleware('auth');

Route::get('/mensajes', function () {
    return view('mensajes');
})->middleware('auth');

Route::get('/compras-y-ventas', function () {
    return view('compraventa');
})->middleware('auth');

Route::get('/libro/{n}', function ($n) {
    $libro = Libro::where('id', '=', $n)->get();
    return view('libro')->with(['libro'=>$libro]);
})->middleware('auth');

Route::resource('libros', LibroController::class)->middleware('auth');
Route::resource('categorias', CategoriaController::class)->middleware('auth');
Route::resource('users', UserController::class);
Route::resource('userinfo', UserInfoController::class);
Route::resource('carrito', CarritoController::class)->middleware('auth');
Route::resource('pedido', PedidoController::class)->middleware('auth');
Route::resource('pedidodetalle', PedidoDetalleController::class)->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
