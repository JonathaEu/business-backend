<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'divida',
        'users_id'
    ];

    protected $table = 'clientes';

    public function emprestimos()
    {
        return $this->belongsToMany('App\Models\Emprestimos', 'emprestimos_id');
    }
}
