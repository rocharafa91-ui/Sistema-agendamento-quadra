@extends('layout')
@section('titulo', 'Novo Espaço')
@section('conteudo')
    <h1>Cadastrar Espaço de Lazer</h1>
    <form action="{{ route('espacos_lazer.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" value="{{ old('nome') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Capacidade (pessoas)</label>
            <input type="number" name="capacidade" min="1" class="form-control" value="{{ old('capacidade', 10) }}" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="disponivel" value="1" class="form-check-input" id="disp" checked>
            <label class="form-check-label" for="disp">Disponível</label>
        </div>
        <button class="btn btn-primary">Salvar</button>
        <a href="{{ route('espacos_lazer.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
