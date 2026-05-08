@extends('layout')
@section('titulo', 'Quadras')
@section('conteudo')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Quadras</h1>
        <a href="{{ route('quadras.create') }}" class="btn btn-success">+ Nova Quadra</a>
    </div>
    <table class="table table-striped table-bordered">
        <thead class="table-dark"><tr><th>ID</th><th>Nome</th><th>Tipo</th><th>Disponível</th><th width="220">Ações</th></tr></thead>
        <tbody>
            @forelse($quadras as $quadra)
                <tr>
                    <td>{{ $quadra->id }}</td>
                    <td>{{ $quadra->nome }}</td>
                    <td>{{ $quadra->tipo }}</td>
                    <td>{!! $quadra->disponivel ? '<span class="badge bg-success">Sim</span>' : '<span class="badge bg-danger">Não</span>' !!}</td>
                    <td>
                        <a href="{{ route('quadras.show', $quadra) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('quadras.edit', $quadra) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('quadras.destroy', $quadra) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir?')">
                            @csrf @method('DELETE')<button class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty<tr><td colspan="5" class="text-center">Nenhuma quadra.</td></tr>@endforelse
        </tbody>
    </table>
    {{ $quadras->links() }}
@endsection
