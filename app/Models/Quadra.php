<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * MODEL: Quadra
 *
 * Representa uma quadra esportiva reservável.
 * Relacionamento: Quadra hasMany Reserva.
 */
class Quadra extends Model
{
    use HasFactory;

    protected $table = 'quadras';

    public const TIPOS = ['Futebol', 'Tênis', 'Basquete', 'Vôlei', 'Poliesportiva'];

    protected $fillable = [
        'nome',
        'tipo',
        'disponivel',
    ];

    protected $casts = [
        'disponivel' => 'boolean',
    ];

    /**
     * Uma quadra pode ter várias reservas.
     */
    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class);
    }
}
