<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']);
    }
    
    public function index(User $user){
        // dd('Desde Muro');
        // dd(auth()->user());

        //video 112
        // $post = Post::where('user_id', $user->id)->get();

        //Video 115
        $posts = Post::where('user_id', $user->id)->latest()->paginate(4);
        // $posts = Post::where('user_id', $user->id)->simplePaginate(4);

        return view('dashboard', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function create(){
        // dd('Creando post');
        return view('posts.create');
    }

    public function store(Request $request){
        // dd('Creando publicacion');

        //Validar formulario
        $this->validate($request, [
            'titulo' => 'required|max:255',
            'descripcion'=> 'required',
            'imagen' => 'required'
        ]);

        //Video 106
        // Post::create([
        //     'titulo' => $request->titulo,
        //     'descripcion' => $request->descripcion,
        //     'imagen' => $request->imagen,
        //     'user_id' => auth()->user()->id
        // ]);

        //video 107 otra forma de insertar registros
        // $post = new Post;
        // $post->titulo = $request->titulo;
        // $post->descripcion = $request->descripcion;
        // $post->imagen = $request->imagen;
        // $post->user_id = auth()->user()->id;
        // $post->save();

        //video 111. Usando una relacion
        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id
        ]);


        //video 106
        return redirect()->route('posts.index', auth()->user()->username);
    }

    //video 118
    public function show(User $user, Post $post){
        return view('posts.show', [
            'post' => $post,
            'user' => $user
        ]);
    }

    //video 127
    public function destroy(Post $post){
        // dd('Eliminando', $post->id);

        // if($post->user_id === auth()->user()->id){
        //     dd('Si es la misma persona');
        // }
        // else{
        //     dd('No es la misma persona');
        // }

        $this->authorize('delete', $post);
        $post->delete();

        //eliminar la imagen
        $imagen_path = public_path('uploads/'.$post->imagen);

        if(File::exists($imagen_path)){
            unlink($imagen_path);
        }

        return redirect()->route('posts.index', auth()->user()->username);
    }
}
