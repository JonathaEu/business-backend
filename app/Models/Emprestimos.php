<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emprestimos extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao_emprestimo',
        'valor_emprestimo',
        'data_emprestimo',
        'previsao_pagamento',
        'pago',
        'metodo_emprestimo',
        'clientes_id',
        'users_id',
    ];

    protected $table = 'emprestimos';

    public function clientes()
    {
        return $this->hasOne('App\Models\Clientes', 'id', 'clientes_id');
    }
}
