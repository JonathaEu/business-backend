<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rendimentos extends Model
{
    use HasFactory;

    protected $fillable = [
        'investimentos_id',
        'valor_rendimento',
        'data_rendimento'
    ];

    protected $table = 'rendimentos';

    public function investimentos()
    {
        return $this->belongsTo(Investimentos::class);
    }
}
