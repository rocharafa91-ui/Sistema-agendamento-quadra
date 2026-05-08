@extends('layout')
@section('titulo', 'Usuários')
@section('conteudo')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Usuários</h1>
        <a href="{{ route('usuarios.create') }}" class="btn btn-success">+ Novo Usuário</a>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr><th>ID</th><th>Nome</th><th>E-mail</th><th>Telefone</th><th width="220">Ações</th></tr>
        </thead>
        <tbody>
            @forelse($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id }}</td>
                    <td>{{ $usuario->nome }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->telefone }}</td>
                    <td>
                        <a href="{{ route('usuarios.show', $usuario) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Excluir usuário?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Nenhum usuário cadastrado.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $usuarios->links() }}
@endsection
