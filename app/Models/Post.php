<?php

namespace App\Models;

use App\Models\Like;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class)->select(['name', 'username']);
    }

    //Video 126
    public function comentarios(){
        return $this->hasMany(Comentario::class);
    }

    //Video 134
    public function likes(){
        return $this->hasMany(Like::class);
    }

    //Video 135
    public function checkLike(User $user){
        return $this->likes->contains('user_id', $user->id);
    }
}
