<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * MODEL: Reserva
 *
 * Representa uma reserva feita por um usuário.
 * Pode ser para uma Quadra OU um EspacoLazer (ambos opcionais).
 *
 * Relacionamentos:
 *   - Reserva belongsTo Usuario
 *   - Reserva belongsTo Quadra (opcional)
 *   - Reserva belongsTo EspacoLazer (opcional)
 */
class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';

    public const STATUS = ['pendente', 'confirmada', 'cancelada'];

    protected $fillable = [
        'usuario_id',
        'quadra_id',
        'espaco_lazer_id',
        'data',
        'horario',
        'status',
    ];

    protected $casts = [
        'data' => 'date',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }

    public function quadra(): BelongsTo
    {
        return $this->belongsTo(Quadra::class);
    }

    public function espacoLazer(): BelongsTo
    {
        return $this->belongsTo(EspacoLazer::class, 'espaco_lazer_id');
    }

    /**
     * Confirma a reserva (somente se estiver pendente).
     */
    public function confirmar(): bool
    {
        if ($this->status === 'pendente') {
            $this->update(['status' => 'confirmada']);
            return true;
        }
        return false;
    }

    /**
     * Cancela a reserva.
     */
    public function cancelar(): void
    {
        if ($this->status !== 'cancelada') {
            $this->update(['status' => 'cancelada']);
        }
    }
}
