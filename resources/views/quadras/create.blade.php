@extends('layout')
@section('titulo', 'Nova Quadra')
@section('conteudo')
    <h1>Cadastrar Quadra</h1>
    <form action="{{ route('quadras.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" value="{{ old('nome') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tipo</label>
            <select name="tipo" class="form-select" required>
                @foreach($tipos as $t)
                    <option value="{{ $t }}" @selected(old('tipo') === $t)>{{ $t }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="disponivel" value="1" class="form-check-input" id="disp" checked>
            <label class="form-check-label" for="disp">Disponível</label>
        </div>
        <button class="btn btn-primary">Salvar</button>
        <a href="{{ route('quadras.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
