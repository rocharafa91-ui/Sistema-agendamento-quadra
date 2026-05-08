<?php

namespace App\Http\Controllers;

use App\Models\Bar;
use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::with('bar')->orderBy('nome')->paginate(10);
        return view('produtos.index', compact('produtos'));
    }

    public function create()
    {
        $bars = Bar::orderBy('nome')->get();
        return view('produtos.create', compact('bars'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'bar_id'  => 'nullable|exists:bars,id',
            'nome'    => 'required|string|max:255',
            'preco'   => 'required|numeric|min:0',
            'estoque' => 'required|integer|min:0',
        ]);

        Produto::create($dados);

        return redirect()->route('produtos.index')
            ->with('sucesso', 'Produto cadastrado com sucesso!');
    }

    public function show(Produto $produto)
    {
        $produto->load('bar');
        return view('produtos.show', compact('produto'));
    }

    public function edit(Produto $produto)
    {
        $bars = Bar::orderBy('nome')->get();
        return view('produtos.edit', compact('produto', 'bars'));
    }

    public function update(Request $request, Produto $produto)
    {
        $dados = $request->validate([
            'bar_id'  => 'nullable|exists:bars,id',
            'nome'    => 'required|string|max:255',
            'preco'   => 'required|numeric|min:0',
            'estoque' => 'required|integer|min:0',
        ]);

        $produto->update($dados);

        return redirect()->route('produtos.index')
            ->with('sucesso', 'Produto atualizado com sucesso!');
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();
        return redirect()->route('produtos.index')
            ->with('sucesso', 'Produto excluído com sucesso!');
    }

    /**
     * Ação extra: comprar produto (decrementa estoque em 1).
     */
    public function comprar(Produto $produto)
    {
        if ($produto->comprar()) {
            return back()->with('sucesso', "Produto '{$produto->nome}' comprado. Estoque restante: {$produto->estoque}");
        }
        return back()->with('erro', "Produto '{$produto->nome}' está sem estoque.");
    }
}
