<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaGastos extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoria_gastos'
    ];

    protected $table = 'categoria_gastos';
}
