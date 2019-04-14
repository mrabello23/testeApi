<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    protected $table = 'telefones';

    protected $casts = [
        'id_usuario' => 'int'
    ];

    protected $fillable = [
        'numero',
        'id_usuario'
    ];

    public function usuario()
    {
        return $this->belongsTo(\App\Usuario::class, 'id_usuario');
    }
}
