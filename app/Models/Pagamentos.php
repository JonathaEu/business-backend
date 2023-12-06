<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagamentos extends Model {
    use HasFactory;

    protected $fillable = [
        'descricao_pagamento',
        'valor_pagamento',
        'data_pagamento',
        'cliente_id',
    ];

    protected $table = 'pagamentos';
}
