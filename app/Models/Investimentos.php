<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investimentos extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao_investimento',
        'valor_investimento',
        'data_investimento',
    ];

    protected $table = 'investimentos';
}
