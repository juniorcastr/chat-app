<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    protected $table = 'perfis';
    protected $fillable = ['nome'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'perfil_user');
    }
}

