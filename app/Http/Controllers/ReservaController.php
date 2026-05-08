<?php

namespace App\Http\Controllers;

use App\Models\EspacoLazer;
use App\Models\Quadra;
use App\Models\Reserva;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReservaController extends Controller
{
    public function index()
    {
        $reservas = Reserva::with(['usuario', 'quadra', 'espacoLazer'])
            ->orderBy('data', 'desc')
            ->orderBy('horario', 'desc')
            ->paginate(10);
        return view('reservas.index', compact('reservas'));
    }

    public function create()
    {
        return view('reservas.create', [
            'usuarios' => Usuario::orderBy('nome')->get(),
            'quadras'  => Quadra::where('disponivel', true)->orderBy('nome')->get(),
            'espacos'  => EspacoLazer::where('disponivel', true)->orderBy('nome')->get(),
            'statusList' => Reserva::STATUS,
        ]);
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'usuario_id'      => 'required|exists:usuarios,id',
            'quadra_id'       => 'nullable|exists:quadras,id',
            'espaco_lazer_id' => 'nullable|exists:espacos_lazer,id',
            'data'            => 'required|date',
            'horario'         => 'required|regex:/^\d{2}:\d{2}$/',
            'status'          => ['nullable', Rule::in(Reserva::STATUS)],
        ]);

        // Regra: precisa selecionar OU uma quadra OU um espaço de lazer
        if (empty($dados['quadra_id']) && empty($dados['espaco_lazer_id'])) {
            return back()->withInput()
                ->withErrors(['quadra_id' => 'Selecione uma quadra ou um espaço de lazer.']);
        }

        $dados['status'] = $dados['status'] ?? 'pendente';

        Reserva::create($dados);

        return redirect()->route('reservas.index')
            ->with('sucesso', 'Reserva criada com sucesso!');
    }

    public function show(Reserva $reserva)
    {
        $reserva->load(['usuario', 'quadra', 'espacoLazer']);
        return view('reservas.show', compact('reserva'));
    }

    public function edit(Reserva $reserva)
    {
        return view('reservas.edit', [
            'reserva'    => $reserva,
            'usuarios'   => Usuario::orderBy('nome')->get(),
            'quadras'    => Quadra::orderBy('nome')->get(),
            'espacos'    => EspacoLazer::orderBy('nome')->get(),
            'statusList' => Reserva::STATUS,
        ]);
    }

    public function update(Request $request, Reserva $reserva)
    {
        $dados = $request->validate([
            'usuario_id'      => 'required|exists:usuarios,id',
            'quadra_id'       => 'nullable|exists:quadras,id',
            'espaco_lazer_id' => 'nullable|exists:espacos_lazer,id',
            'data'            => 'required|date',
            'horario'         => 'required|regex:/^\d{2}:\d{2}$/',
            'status'          => ['required', Rule::in(Reserva::STATUS)],
        ]);

        $reserva->update($dados);

        return redirect()->route('reservas.index')
            ->with('sucesso', 'Reserva atualizada com sucesso!');
    }

    public function destroy(Reserva $reserva)
    {
        $reserva->delete();
        return redirect()->route('reservas.index')
            ->with('sucesso', 'Reserva excluída com sucesso!');
    }

    /**
     * Ação extra: confirmar reserva.
     */
    public function confirmar(Reserva $reserva)
    {
        if ($reserva->confirmar()) {
            return back()->with('sucesso', "Reserva #{$reserva->id} confirmada.");
        }
        return back()->with('erro', "Reserva #{$reserva->id} não pôde ser confirmada (status: {$reserva->status}).");
    }

    /**
     * Ação extra: cancelar reserva.
     */
    public function cancelar(Reserva $reserva)
    {
        $reserva->cancelar();
        return back()->with('sucesso', "Reserva #{$reserva->id} cancelada.");
    }
}
