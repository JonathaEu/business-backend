<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaGastos extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoria_gastos',
        'users_id'
    ];

    protected $table = 'categoria_gastos';

    public function pendencias()
    {
        return $this->hasOne(Pendencias::class);
    }
}
