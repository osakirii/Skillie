<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carreiras extends Model
{

    protected $fillable = ['nome', 'desc', 'categoria', 'atributosIniciais', 'imagem'];

    protected $casts = [
        'atributosIniciais' => 'array',
    ];

    public function situacoes(){
        return $this->hasMany(Situacoes::class, 'carreira_id');
    }
}
