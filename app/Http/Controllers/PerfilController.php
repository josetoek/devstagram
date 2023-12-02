<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        // dd('Aqui se muestra el formulario');

        return view('perfil.index');
    }

    //video 142
    public function store(Request $request){
        // dd('Guardando cambios');

        //Modificar el request
        $request->request->add(['username' => Str::slug($request->username)]);

        //validaciones
        $this->validate($request,[
            // 'username' => 'required|unique:users|min:3|max:20'
            'username' => [
                'required',
                'unique:users,username,'.auth()->user()->id,
                'min:3',
                'max:20',
                'not_in:editar-perfil'
            ]
        ]);

        //validar la imagen
        if($request->imagen){
            // dd('Si hay imagen');
            $imagen = $request->file('imagen');

            $nombreImagen = Str::uuid() . '.' . $imagen->extension();

            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000,1000);

            $imagePath = public_path('perfiles') . '/' . $nombreImagen;

            $imagenServidor->save($imagePath);
        }

        //Guardar cambios
        $usuario = User::find(auth()->user()->id);
        
        $usuario->username = $request->username;
        //Esto es de 142
        // $usuario->imagen = $nombreImagen ?? '';
        
        //Esto es de 144
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;

        $usuario->save();

        //Redireccionar al usuario
        return redirect()->route('posts.index', $usuario->username);
    }
}
