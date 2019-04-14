<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assinatura extends Model
{
    protected $table = 'assinaturas';

    protected $casts = [
        'id_usuario' => 'int',
        'id_plano' => 'int'
    ];

    protected $fillable = [
        'codigo',
        'cartao',
        'vencimento',
        'cod_cartao',
        'status',
        'id_usuario',
        'id_plano'
    ];

    public function usuario()
    {
        return $this->belongsTo(\App\Usuario::class, 'id_usuario');
    }

    public function plano()
    {
        return $this->belongsTo(\App\Plano::class, 'id_plano');
    }
}
