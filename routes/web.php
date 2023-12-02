<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//154 Convertir esta ruta a
// Route::get('/', function () {
//     return view('principal');
// });

// Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/', HomeController::class)->name('home');

// Route::get('/crear-cuenta', [RegisterController::class, 'index']);
// Route::post('/crear-cuenta', [RegisterController::class, 'store']);

//Rutas con nombre
Route::get('/crear-cuenta', [RegisterController::class, 'index'])->name('register');
Route::post('/crear-cuenta', [RegisterController::class, 'store']);

//Ruta del login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

//Rutas para administra el perfil
Route::get('/editar-perfil', [PerfilController::class, 'index'])->name('perfil.index');
Route::post('/editar-perfil', [PerfilController::class, 'store'])->name('perfil.store');

//Ruta para redireccionar
// Route::get('/muro', [PostController::class, 'index'])->name('post.index');

//Rutas dinamicas
Route::get('/{user:username}', [PostController::class, 'index'])->name('posts.index');

//Ruta para crear un post
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');

//Ruta para las imagenes
Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');

//Ruta para guardar las publicaciones
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

//Ruta para ver una publicacion
Route::get('/{user:username}/posts/{post}', [PostController::class, 'show'])->name('posts.show');

//Ruta para guardar un comentario
Route::post('/{user:username}/posts/{post}', [ComentarioController::class, 'store'])->name('comentarios.store');

//Ruta para eliminar un comentario
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

//Ruta para dar like a las fotos
Route::post('/post/{post}/likes', [LikeController::class, 'store'])->name('posts.likes.store');

//Ruta para eliminar un comentario
Route::delete('/posts/{post}/likes', [LikeController::class, 'destroy'])->name('posts.likes.destroy');

//Ruta para seguir usuarios
Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->name('users.follow');
Route::delete('/{user:username}/unfollow', [FollowerController::class, 'destroy'])->name('users.unfollow');

//