<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historico extends Model
{
    use HasFactory;
    protected $fillable = ['resultado', 'data_jogo', 'atributos_finais', 'carreira_id', 'user_id'];

    public function carreira(){
        return $this->belongsTo(Carreiras::class, 'carreira_id');
    }
    public function usuario(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
