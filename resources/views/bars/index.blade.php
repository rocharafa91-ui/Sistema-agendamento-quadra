@extends('layout')
@section('titulo', 'Bares')
@section('conteudo')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Bares</h1>
        <a href="{{ route('bars.create') }}" class="btn btn-success">+ Novo Bar</a>
    </div>
    <table class="table table-striped table-bordered">
        <thead class="table-dark"><tr><th>ID</th><th>Nome</th><th>Produtos</th><th width="220">Ações</th></tr></thead>
        <tbody>
            @forelse($bars as $bar)
                <tr>
                    <td>{{ $bar->id }}</td>
                    <td>{{ $bar->nome }}</td>
                    <td>{{ $bar->produtos_count }} produto(s)</td>
                    <td>
                        <a href="{{ route('bars.show', $bar) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('bars.edit', $bar) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('bars.destroy', $bar) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir?')">
                            @csrf @method('DELETE')<button class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty<tr><td colspan="4" class="text-center">Nenhum bar.</td></tr>@endforelse
        </tbody>
    </table>
    {{ $bars->links() }}
@endsection
