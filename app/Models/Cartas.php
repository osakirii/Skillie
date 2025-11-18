<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\ValoresCarta;

class Cartas extends Model implements ValoresCarta
{
    use HasFactory;

    protected $fillable = ['nome', 'desc', 'imagem', 'efeitos'];

    /**
     * Ensure the `efeitos` JSON column is cast to array when accessed
     */
    protected $casts = [
        'efeitos' => 'array',
    ];

    public function getEstresse(): int
    {
        return (int) ($this->efeitos['estresse'] ?? 0);
    }

    public function getDinheiro(): int
    {
        return (int) ($this->efeitos['dinheiro'] ?? 0);
    }

    public function getReputacao(): int
    {
        return (int) ($this->efeitos['reputacao'] ?? 0);
    }
}
