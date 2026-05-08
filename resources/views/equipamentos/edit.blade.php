@extends('layout')
@section('titulo', 'Editar Equipamento')
@section('conteudo')
    <h1>Editar Equipamento</h1>
    <form action="{{ route('equipamentos.update', $equipamento) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3"><label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" value="{{ old('nome', $equipamento->nome) }}" required></div>
        <div class="mb-3"><label class="form-label">Tipo</label>
            <input type="text" name="tipo" class="form-control" value="{{ old('tipo', $equipamento->tipo) }}" required></div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="disponivel" value="1" class="form-check-input" id="disp" @checked($equipamento->disponivel)>
            <label class="form-check-label" for="disp">Disponível</label>
        </div>
        <button class="btn btn-primary">Atualizar</button>
        <a href="{{ route('equipamentos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
