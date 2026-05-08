<?php

namespace App\Http\Controllers;

use App\Models\Bar;
use Illuminate\Http\Request;

class BarController extends Controller
{
    public function index()
    {
        $bars = Bar::withCount('produtos')->orderBy('nome')->paginate(10);
        return view('bars.index', compact('bars'));
    }

    public function create()
    {
        return view('bars.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        Bar::create($dados);

        return redirect()->route('bars.index')
            ->with('sucesso', 'Bar cadastrado com sucesso!');
    }

    public function show(Bar $bar)
    {
        $bar->load('produtos');
        return view('bars.show', compact('bar'));
    }

    public function edit(Bar $bar)
    {
        return view('bars.edit', compact('bar'));
    }

    public function update(Request $request, Bar $bar)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $bar->update($dados);

        return redirect()->route('bars.index')
            ->with('sucesso', 'Bar atualizado com sucesso!');
    }

    public function destroy(Bar $bar)
    {
        $bar->delete();
        return redirect()->route('bars.index')
            ->with('sucesso', 'Bar excluído com sucesso!');
    }
}
