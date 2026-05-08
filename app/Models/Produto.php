<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * MODEL: Produto
 *
 * Representa um produto vendido no bar.
 * Relacionamento: Produto belongsTo Bar.
 */
class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    protected $fillable = [
        'bar_id',
        'nome',
        'preco',
        'estoque',
    ];

    protected $casts = [
        'preco'   => 'decimal:2',
        'estoque' => 'integer',
    ];

    /**
     * Um produto pertence a um bar.
     */
    public function bar(): BelongsTo
    {
        return $this->belongsTo(Bar::class);
    }

    /**
     * Comportamento: comprar produto reduz o estoque em 1.
     */
    public function comprar(): bool
    {
        if ($this->estoque > 0) {
            $this->decrement('estoque');
            return true;
        }
        return false;
    }
}
