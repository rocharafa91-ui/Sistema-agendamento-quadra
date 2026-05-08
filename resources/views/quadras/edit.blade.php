@extends('layout')
@section('titulo', 'Editar Quadra')
@section('conteudo')
    <h1>Editar Quadra</h1>
    <form action="{{ route('quadras.update', $quadra) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" value="{{ old('nome', $quadra->nome) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tipo</label>
            <select name="tipo" class="form-select" required>
                @foreach($tipos as $t)
                    <option value="{{ $t }}" @selected(old('tipo', $quadra->tipo) === $t)>{{ $t }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="disponivel" value="1" class="form-check-input" id="disp" @checked($quadra->disponivel)>
            <label class="form-check-label" for="disp">Disponível</label>
        </div>
        <button class="btn btn-primary">Atualizar</button>
        <a href="{{ route('quadras.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
