@extends('layout')
@section('titulo', 'Produtos')
@section('conteudo')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Produtos</h1>
        <a href="{{ route('produtos.create') }}" class="btn btn-success">+ Novo Produto</a>
    </div>
    <table class="table table-striped table-bordered">
        <thead class="table-dark"><tr><th>ID</th><th>Nome</th><th>Bar</th><th>Preço</th><th>Estoque</th><th width="280">Ações</th></tr></thead>
        <tbody>
            @forelse($produtos as $produto)
                <tr>
                    <td>{{ $produto->id }}</td>
                    <td>{{ $produto->nome }}</td>
                    <td>{{ $produto->bar->nome ?? '—' }}</td>
                    <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                    <td>{{ $produto->estoque }}</td>
                    <td>
                        <a href="{{ route('produtos.edit', $produto) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('produtos.comprar', $produto) }}" method="POST" class="d-inline">
                            @csrf<button class="btn btn-primary btn-sm" {{ $produto->estoque <= 0 ? 'disabled' : '' }}>Comprar</button>
                        </form>
                        <form action="{{ route('produtos.destroy', $produto) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir?')">
                            @csrf @method('DELETE')<button class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty<tr><td colspan="6" class="text-center">Nenhum produto.</td></tr>@endforelse
        </tbody>
    </table>
    {{ $produtos->links() }}
@endsection
