<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    //
    public function store(Request $request, User $user, Post $post){
        // dd('Comentando');

        //Validar
        $this->validate($request, [
            'comentario' => 'required|max:255'
        ]);

        //guardar comentario
        Comentario::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comentario' => $request->comentario
        ]);

        //redireccionar al usuario
        return back()->with('mensaje', 'Comentario guardado correctamente');
    }
}
