<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //Normalmente seria
    // public function index(){
    //     dd('Home');
    // }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke()
    {
        // dd(auth()->user());
        // obtener a las personas que seguimos
        $ids = auth()->user()->followings->pluck('id')->toArray();
        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20);

        return view('home', [
            'posts' => $posts
        ]);

    }
}
