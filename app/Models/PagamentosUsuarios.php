<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagamentosUsuarios extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'pendencias_id',
        'valor_pagamento',
        'debito_total',
        'descricao_pagamento',
        'data_pagamento',
        'metodo_pagamento',
        'juros',
        'numero_parcela'
    ];

    protected $table = 'pagamentos_usuarios';

    public function pendencias()
    {
        return $this->belongsTo(Pendencias::class);
    }
}
