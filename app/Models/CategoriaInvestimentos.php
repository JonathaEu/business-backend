<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaInvestimentos extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoria_investimentos',
        'users_id'
    ];

    protected $table = 'categoria_investimentos';

    public function investimentos()
    {
        return $this->hasOne(Investimentos::class);
    }
}
