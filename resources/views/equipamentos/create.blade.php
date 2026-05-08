@extends('layout')
@section('titulo', 'Novo Equipamento')
@section('conteudo')
    <h1>Cadastrar Equipamento</h1>
    <form action="{{ route('equipamentos.store') }}" method="POST">
        @csrf
        <div class="mb-3"><label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" value="{{ old('nome') }}" required></div>
        <div class="mb-3"><label class="form-label">Tipo</label>
            <input type="text" name="tipo" class="form-control" value="{{ old('tipo') }}" placeholder="Futebol, Tênis, etc" required></div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="disponivel" value="1" class="form-check-input" id="disp" checked>
            <label class="form-check-label" for="disp">Disponível</label>
        </div>
        <button class="btn btn-primary">Salvar</button>
        <a href="{{ route('equipamentos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
