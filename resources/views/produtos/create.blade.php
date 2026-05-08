@extends('layout')
@section('titulo', 'Novo Produto')
@section('conteudo')
    <h1>Cadastrar Produto</h1>
    <form action="{{ route('produtos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Bar (opcional)</label>
            <select name="bar_id" class="form-select">
                <option value="">-- nenhum --</option>
                @foreach($bars as $b)
                    <option value="{{ $b->id }}" @selected(old('bar_id') == $b->id)>{{ $b->nome }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3"><label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" value="{{ old('nome') }}" required></div>
        <div class="row">
            <div class="col-md-6 mb-3"><label class="form-label">Preço</label>
                <input type="number" step="0.01" min="0" name="preco" class="form-control" value="{{ old('preco') }}" required></div>
            <div class="col-md-6 mb-3"><label class="form-label">Estoque</label>
                <input type="number" min="0" name="estoque" class="form-control" value="{{ old('estoque', 0) }}" required></div>
        </div>
        <button class="btn btn-primary">Salvar</button>
        <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
