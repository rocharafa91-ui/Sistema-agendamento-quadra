<?php

namespace App\Http\Controllers;

use App\Models\EspacoLazer;
use Illuminate\Http\Request;

class EspacoLazerController extends Controller
{
    public function index()
    {
        $espacos = EspacoLazer::orderBy('nome')->paginate(10);
        return view('espacos_lazer.index', compact('espacos'));
    }

    public function create()
    {
        return view('espacos_lazer.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome'       => 'required|string|max:255',
            'capacidade' => 'required|integer|min:1',
            'disponivel' => 'nullable|boolean',
        ]);
        $dados['disponivel'] = $request->boolean('disponivel', true);

        EspacoLazer::create($dados);

        return redirect()->route('espacos_lazer.index')
            ->with('sucesso', 'Espaço de lazer cadastrado com sucesso!');
    }

    public function show(EspacoLazer $espacos_lazer)
    {
        $espacos_lazer->load('reservas.usuario');
        return view('espacos_lazer.show', ['espaco' => $espacos_lazer]);
    }

    public function edit(EspacoLazer $espacos_lazer)
    {
        return view('espacos_lazer.edit', ['espaco' => $espacos_lazer]);
    }

    public function update(Request $request, EspacoLazer $espacos_lazer)
    {
        $dados = $request->validate([
            'nome'       => 'required|string|max:255',
            'capacidade' => 'required|integer|min:1',
            'disponivel' => 'nullable|boolean',
        ]);
        $dados['disponivel'] = $request->boolean('disponivel');

        $espacos_lazer->update($dados);

        return redirect()->route('espacos_lazer.index')
            ->with('sucesso', 'Espaço de lazer atualizado com sucesso!');
    }

    public function destroy(EspacoLazer $espacos_lazer)
    {
        $espacos_lazer->delete();
        return redirect()->route('espacos_lazer.index')
            ->with('sucesso', 'Espaço de lazer excluído com sucesso!');
    }
}
