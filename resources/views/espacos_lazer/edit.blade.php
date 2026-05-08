@extends('layout')
@section('titulo', 'Editar Espaço')
@section('conteudo')
    <h1>Editar Espaço de Lazer</h1>
    <form action="{{ route('espacos_lazer.update', $espaco) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" value="{{ old('nome', $espaco->nome) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Capacidade</label>
            <input type="number" name="capacidade" min="1" class="form-control" value="{{ old('capacidade', $espaco->capacidade) }}" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="disponivel" value="1" class="form-check-input" id="disp" @checked($espaco->disponivel)>
            <label class="form-check-label" for="disp">Disponível</label>
        </div>
        <button class="btn btn-primary">Atualizar</button>
        <a href="{{ route('espacos_lazer.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
