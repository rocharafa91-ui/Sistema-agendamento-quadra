<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * MODEL: Equipamento
 *
 * Representa um equipamento disponível para aluguel.
 */
class Equipamento extends Model
{
    use HasFactory;

    protected $table = 'equipamentos';

    protected $fillable = [
        'nome',
        'tipo',
        'disponivel',
    ];

    protected $casts = [
        'disponivel' => 'boolean',
    ];

    /**
     * Aluga o equipamento (marca como indisponível).
     */
    public function alugar(): bool
    {
        if ($this->disponivel) {
            $this->update(['disponivel' => false]);
            return true;
        }
        return false;
    }

    /**
     * Devolve o equipamento (marca como disponível novamente).
     */
    public function devolver(): void
    {
        $this->update(['disponivel' => true]);
    }
}
