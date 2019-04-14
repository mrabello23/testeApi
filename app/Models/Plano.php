<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    protected $table = 'planos';

    protected $casts = [
        'valor' => 'float'
    ];

    protected $fillable = [
        'nome',
        'valor',
        'descricao',
        'diferencial'
    ];

    public function assinaturas()
    {
        return $this->hasMany(\App\Assinatura::class, 'id_plano');
    }
}
