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
        'data_aporte',
        'nome_investimento',
        'users_id',
        'categoria_investimentos_id',
    ];

    protected $table = 'investimentos';

    public function rendimentos()
    {
        return $this->hasMany(Rendimentos::class);
    }

    public function categoriaInvestimentos()
    {
        return $this->belongsTo(CategoriaInvestimentos::class);
    }
}
