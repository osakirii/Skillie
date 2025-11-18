<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Situacoes extends Model
{
    use HasFactory;    
    protected $fillable = ['nome', 'desc', 'carreira_id', 'decisao1_id', 'decisao2_id'];

    public function decisao1(){
        return $this->belongsTo(Cartas::class, 'decisao1_id');
    }

    public function decisao2(){
        return $this->belongsTo(Cartas::class, 'decisao2_id');
    }

    public function carreira(){
        return $this->belongsTo(Carreiras::class, 'carreira_id');
    }
}
