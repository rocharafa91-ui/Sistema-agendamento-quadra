<?php

namespace App\Http\Controllers;

use App\Models\Bar;
use App\Models\Equipamento;
use App\Models\EspacoLazer;
use App\Models\Produto;
use App\Models\Quadra;
use App\Models\Reserva;
use App\Models\Usuario;

/**
 * CONTROLLER do Dashboard (página inicial).
 *
 * Mostra contadores gerais e um gráfico de reservas por status.
 */
class DashboardController extends Controller
{
    public function index()
    {
        // Contadores
        $totais = [
            'usuarios'      => Usuario::count(),
            'reservas'      => Reserva::count(),
            'quadras'       => Quadra::count(),
            'espacos'       => EspacoLazer::count(),
            'equipamentos'  => Equipamento::count(),
            'bars'          => Bar::count(),
            'produtos'      => Produto::count(),
        ];

        // Reservas por status (para o gráfico)
        $reservasPorStatus = [
            'pendente'   => Reserva::where('status', 'pendente')->count(),
            'confirmada' => Reserva::where('status', 'confirmada')->count(),
            'cancelada'  => Reserva::where('status', 'cancelada')->count(),
        ];

        // Próximas reservas (próximos 7 dias, exceto canceladas)
        $proximasReservas = Reserva::with(['usuario', 'quadra', 'espacoLazer'])
            ->where('data', '>=', now()->toDateString())
            ->where('status', '!=', 'cancelada')
            ->orderBy('data')
            ->orderBy('horario')
            ->limit(5)
            ->get();

        // Equipamentos alugados
        $equipamentosAlugados = Equipamento::where('disponivel', false)->count();

        // Produtos com estoque baixo (< 5)
        $produtosEstoqueBaixo = Produto::where('estoque', '<', 5)->count();

        return view('home', compact(
            'totais',
            'reservasPorStatus',
            'proximasReservas',
            'equipamentosAlugados',
            'produtosEstoqueBaixo'
        ));
    }
}
