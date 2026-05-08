@extends('layout')
@section('titulo', 'Produto')
@section('conteudo')
    <h1>{{ $produto->nome }}</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Bar:</strong> {{ $produto->bar->nome ?? '—' }}</p>
            <p><strong>Preço:</strong> R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
            <p><strong>Estoque:</strong> {{ $produto->estoque }}</p>
        </div>
    </div>
    <div class="mt-3">
        <a href="{{ route('produtos.edit', $produto) }}" class="btn btn-warning">Editar</a>
        <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Voltar</a>
    </div>
@endsection
