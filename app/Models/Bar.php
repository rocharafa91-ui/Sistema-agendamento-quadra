<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * MODEL: Bar
 *
 * Representa um bar do estabelecimento. Possui vários produtos no cardápio.
 * Relacionamento: Bar hasMany Produto.
 */
class Bar extends Model
{
    use HasFactory;

    protected $table = 'bars';

    protected $fillable = [
        'nome',
    ];

    /**
     * Um bar tem vários produtos.
     */
    public function produtos(): HasMany
    {
        return $this->hasMany(Produto::class);
    }
}
