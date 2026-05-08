@extends('layout')
@section('titulo', 'Editar Bar')
@section('conteudo')
    <h1>Editar Bar</h1>
    <form action="{{ route('bars.update', $bar) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3"><label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" value="{{ old('nome', $bar->nome) }}" required></div>
        <button class="btn btn-primary">Atualizar</button>
        <a href="{{ route('bars.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
