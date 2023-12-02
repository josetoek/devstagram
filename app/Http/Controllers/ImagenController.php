<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    //
    public function store(Request $request){
        // return "Desde imagen controller";

        $imagen = $request->file('file');

        // return response()->json(['imagen' => $imagen->extension()]);

        //Esto es del video 98
        $nombreImagen = Str::uuid() . '.' . $imagen->extension();

        $imagenServidor = Image::make($imagen);
        $imagenServidor->fit(1000,1000);

        $imagePath = public_path('uploads') . '/' . $nombreImagen;

        $imagenServidor->save($imagePath);

        //Esto es del video 98
        return response()->json(['imagen' => $nombreImagen]);
    }
}
