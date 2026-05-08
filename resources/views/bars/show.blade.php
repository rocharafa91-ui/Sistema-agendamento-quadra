@extends('layout')
@section('titulo', 'Bar')
@section('conteudo')
    <h1>{{ $bar->nome }}</h1>

    <h3 class="mt-3">Cardápio</h3>
    <table class="table">
        <thead><tr><th>Produto</th><th>Preço</th><th>Estoque</th></tr></thead>
        <tbody>
            @forelse($bar->produtos as $p)
                <tr>
                    <td>{{ $p->nome }}</td>
                    <td>R$ {{ number_format($p->preco, 2, ',', '.') }}</td>
                    <td>{{ $p->estoque }}</td>
                </tr>
            @empty<tr><td colspan="3" class="text-center">Sem produtos cadastrados.</td></tr>@endforelse
        </tbody>
    </table>

    <a href="{{ route('bars.edit', $bar) }}" class="btn btn-warning">Editar</a>
    <a href="{{ route('bars.index') }}" class="btn btn-secondary">Voltar</a>
@endsection
