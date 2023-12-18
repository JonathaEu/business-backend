<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaInvestimentos extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoria_investimentos'
    ];

    protected $table = 'categoria_investimentos';
}
