<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::orderBy('nome')->paginate(10);
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome'     => 'required|string|max:255',
            'email'    => 'required|email|unique:usuarios,email',
            'telefone' => 'required|string|min:10|max:20',
        ]);

        Usuario::create($dados);

        return redirect()->route('usuarios.index')
            ->with('sucesso', 'Usuário cadastrado com sucesso!');
    }

    public function show(Usuario $usuario)
    {
        $usuario->load('reservas.quadra', 'reservas.espacoLazer');
        return view('usuarios.show', compact('usuario'));
    }

    public function edit(Usuario $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $dados = $request->validate([
            'nome'     => 'required|string|max:255',
            'email'    => 'required|email|unique:usuarios,email,' . $usuario->id,
            'telefone' => 'required|string|min:10|max:20',
        ]);

        $usuario->update($dados);

        return redirect()->route('usuarios.index')
            ->with('sucesso', 'Usuário atualizado com sucesso!');
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')
            ->with('sucesso', 'Usuário excluído com sucesso!');
    }
}
