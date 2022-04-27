<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\CategoriaController;
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
})->middleware('guest');

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
})->middleware('auth');


Route::get('/libro/{n}', function ($n) {
    $libro = Libro::where('id', '=', $n)->get();
    return view('libro')->with(['libro'=>$libro]);
})->middleware('auth');

Route::resource('libros', LibroController::class);
Route::resource('categorias', CategoriaController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
