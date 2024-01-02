<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagamentosClientes extends Model
{
    use HasFactory;

    protected $fillable = [
        'emprestimos_id',
        'users_id',
        'clientes_id',
        'descricao',
        'valor_pagamento',
        'debito_total',
        'data_pagamento',
        'metodo_pagamento',
        'numero_parcela'
    ];

    protected $table = 'pagamentos_clientes';

    public function clientes()
    {
        return $this->belongsTo(Clientes::class);
    }
}
