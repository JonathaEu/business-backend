<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gastos extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao_gasto',
        'valor_gasto',
        'data_gasto',
    ];

    protected $table  = 'gastos';
}
