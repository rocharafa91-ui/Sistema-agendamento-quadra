<?php

namespace App\Http\Controllers;

use App\Models\Equipamento;
use Illuminate\Http\Request;

class EquipamentoController extends Controller
{
    public function index()
    {
        $equipamentos = Equipamento::orderBy('nome')->paginate(10);
        return view('equipamentos.index', compact('equipamentos'));
    }

    public function create()
    {
        return view('equipamentos.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome'       => 'required|string|max:255',
            'tipo'       => 'required|string|max:100',
            'disponivel' => 'nullable|boolean',
        ]);
        $dados['disponivel'] = $request->boolean('disponivel', true);

        Equipamento::create($dados);

        return redirect()->route('equipamentos.index')
            ->with('sucesso', 'Equipamento cadastrado com sucesso!');
    }

    public function show(Equipamento $equipamento)
    {
        return view('equipamentos.show', compact('equipamento'));
    }

    public function edit(Equipamento $equipamento)
    {
        return view('equipamentos.edit', compact('equipamento'));
    }

    public function update(Request $request, Equipamento $equipamento)
    {
        $dados = $request->validate([
            'nome'       => 'required|string|max:255',
            'tipo'       => 'required|string|max:100',
            'disponivel' => 'nullable|boolean',
        ]);
        $dados['disponivel'] = $request->boolean('disponivel');

        $equipamento->update($dados);

        return redirect()->route('equipamentos.index')
            ->with('sucesso', 'Equipamento atualizado com sucesso!');
    }

    public function destroy(Equipamento $equipamento)
    {
        $equipamento->delete();
        return redirect()->route('equipamentos.index')
            ->with('sucesso', 'Equipamento excluído com sucesso!');
    }

    /**
     * Ação extra: alugar equipamento.
     */
    public function alugar(Equipamento $equipamento)
    {
        if ($equipamento->alugar()) {
            return back()->with('sucesso', "Equipamento '{$equipamento->nome}' alugado.");
        }
        return back()->with('erro', "Equipamento '{$equipamento->nome}' já está alugado.");
    }

    /**
     * Ação extra: devolver equipamento.
     */
    public function devolver(Equipamento $equipamento)
    {
        $equipamento->devolver();
        return back()->with('sucesso', "Equipamento '{$equipamento->nome}' devolvido.");
    }
}
