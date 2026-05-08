@extends('layout')
@section('titulo', 'Equipamento')
@section('conteudo')
    <h1>{{ $equipamento->nome }}</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Tipo:</strong> {{ $equipamento->tipo }}</p>
            <p><strong>Status:</strong> {{ $equipamento->disponivel ? 'Disponível' : 'Alugado' }}</p>
        </div>
    </div>
    <div class="mt-3">
        <a href="{{ route('equipamentos.edit', $equipamento) }}" class="btn btn-warning">Editar</a>
        <a href="{{ route('equipamentos.index') }}" class="btn btn-secondary">Voltar</a>
    </div>
@endsection
