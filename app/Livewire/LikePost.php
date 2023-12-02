<?php

namespace App\Livewire;

use Livewire\Component;

class LikePost extends Component
{

    //164
    public $post;
    //167
    public $isLiked;
    public $likes;

    //167 Para saber si el usuario ya dio like a la publicacion
    // public function mount($post){
    //     $this->isLiked = $post->checkLike(auth()->user());
    //     $this->likes = $post->likes->count();
    // }

    //165
    public function like(){

        if($this->post->checkLike(auth()->user())){

            $this->post->likes()->where('post_id', $this->post->id)->delete();
            //167
            $this->isLiked = false;
            $this->likes--;

        }
        else{
            $this->post->likes()->create([
                'user_id' => auth()->user()->id
            ]);

            //167
            $this->isLiked = true;
            $this->likes++;
        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
