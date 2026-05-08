@extends('layout')
@section('titulo', 'Novo Bar')
@section('conteudo')
    <h1>Cadastrar Bar</h1>
    <form action="{{ route('bars.store') }}" method="POST">
        @csrf
        <div class="mb-3"><label class="form-label">Nome do Bar</label>
            <input type="text" name="nome" class="form-control" value="{{ old('nome') }}" required></div>
        <button class="btn btn-primary">Salvar</button>
        <a href="{{ route('bars.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
