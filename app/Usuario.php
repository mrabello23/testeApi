<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';

    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'logradouro',
        'bairro',
        'cep',
        'cidade',
        'estado'
    ];

    public function telefones()
    {
        return $this->hasMany(\App\Telefone::class, 'id_usuario');
    }

    public function assinaturas()
    {
        return $this->hasMany(\App\Assinatura::class, 'id_usuario');
    }
}
