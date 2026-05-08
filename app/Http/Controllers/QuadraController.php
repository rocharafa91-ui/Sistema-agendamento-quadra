<?php

namespace App\Http\Controllers;

use App\Models\Quadra;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class QuadraController extends Controller
{
    public function index()
    {
        $quadras = Quadra::orderBy('nome')->paginate(10);
        return view('quadras.index', compact('quadras'));
    }

    public function create()
    {
        return view('quadras.create', ['tipos' => Quadra::TIPOS]);
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome'       => 'required|string|max:255',
            'tipo'       => ['required', Rule::in(Quadra::TIPOS)],
            'disponivel' => 'nullable|boolean',
        ]);
        $dados['disponivel'] = $request->boolean('disponivel', true);

        Quadra::create($dados);

        return redirect()->route('quadras.index')
            ->with('sucesso', 'Quadra cadastrada com sucesso!');
    }

    public function show(Quadra $quadra)
    {
        $quadra->load('reservas.usuario');
        return view('quadras.show', compact('quadra'));
    }

    public function edit(Quadra $quadra)
    {
        return view('quadras.edit', ['quadra' => $quadra, 'tipos' => Quadra::TIPOS]);
    }

    public function update(Request $request, Quadra $quadra)
    {
        $dados = $request->validate([
            'nome'       => 'required|string|max:255',
            'tipo'       => ['required', Rule::in(Quadra::TIPOS)],
            'disponivel' => 'nullable|boolean',
        ]);
        $dados['disponivel'] = $request->boolean('disponivel');

        $quadra->update($dados);

        return redirect()->route('quadras.index')
            ->with('sucesso', 'Quadra atualizada com sucesso!');
    }

    public function destroy(Quadra $quadra)
    {
        $quadra->delete();
        return redirect()->route('quadras.index')
            ->with('sucesso', 'Quadra excluída com sucesso!');
    }
}
