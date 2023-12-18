<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendencias extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'categoria_gastos_id',
        'valor_pendencia',
        'quem_recebe',
        'data_pendencia',
        'descricao_pendencia',
        'parcelas'
    ];

    protected $table = 'pendencias';

    public function categoriaGastos()
    {
        return $this->belongsTo(CategoriaGastos::class);
    }
    public function pagamentosUsuarios()
    {
        return $this->hasMany(PagamentosUsuarios::class);
    }
}
