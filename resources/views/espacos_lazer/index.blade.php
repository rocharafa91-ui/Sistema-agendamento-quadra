@extends('layout')
@section('titulo', 'Espaços de Lazer')
@section('conteudo')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Espaços de Lazer</h1>
        <a href="{{ route('espacos_lazer.create') }}" class="btn btn-success">+ Novo Espaço</a>
    </div>
    <table class="table table-striped table-bordered">
        <thead class="table-dark"><tr><th>ID</th><th>Nome</th><th>Capacidade</th><th>Disponível</th><th width="220">Ações</th></tr></thead>
        <tbody>
            @forelse($espacos as $espaco)
                <tr>
                    <td>{{ $espaco->id }}</td>
                    <td>{{ $espaco->nome }}</td>
                    <td>{{ $espaco->capacidade }}</td>
                    <td>{!! $espaco->disponivel ? '<span class="badge bg-success">Sim</span>' : '<span class="badge bg-danger">Não</span>' !!}</td>
                    <td>
                        <a href="{{ route('espacos_lazer.show', $espaco) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('espacos_lazer.edit', $espaco) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('espacos_lazer.destroy', $espaco) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir?')">
                            @csrf @method('DELETE')<button class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty<tr><td colspan="5" class="text-center">Nenhum espaço.</td></tr>@endforelse
        </tbody>
    </table>
    {{ $espacos->links() }}
@endsection
