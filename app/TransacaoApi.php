<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransacaoApi extends Model
{
    protected $table = 'transacoes';

    protected $fillable = [
        'token',
        'status'
    ];
}
