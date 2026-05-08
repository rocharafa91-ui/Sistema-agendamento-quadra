<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * MODEL: EspacoLazer
 *
 * Representa um espaço de lazer reservável (ex: churrasqueira, salão de festas).
 * Relacionamento: EspacoLazer hasMany Reserva.
 */
class EspacoLazer extends Model
{
    use HasFactory;

    protected $table = 'espacos_lazer';

    protected $fillable = [
        'nome',
        'capacidade',
        'disponivel',
    ];

    protected $casts = [
        'capacidade' => 'integer',
        'disponivel' => 'boolean',
    ];

    /**
     * Um espaço pode ter várias reservas.
     */
    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class);
    }
}
