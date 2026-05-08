@extends('layout')
@section('titulo', 'Editar Produto')
@section('conteudo')
    <h1>Editar Produto</h1>
    <form action="{{ route('produtos.update', $produto) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Bar</label>
            <select name="bar_id" class="form-select">
                <option value="">-- nenhum --</option>
                @foreach($bars as $b)
                    <option value="{{ $b->id }}" @selected(old('bar_id', $produto->bar_id) == $b->id)>{{ $b->nome }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3"><label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" value="{{ old('nome', $produto->nome) }}" required></div>
        <div class="row">
            <div class="col-md-6 mb-3"><label class="form-label">Preço</label>
                <input type="number" step="0.01" min="0" name="preco" class="form-control" value="{{ old('preco', $produto->preco) }}" required></div>
            <div class="col-md-6 mb-3"><label class="form-label">Estoque</label>
                <input type="number" min="0" name="estoque" class="form-control" value="{{ old('estoque', $produto->estoque) }}" required></div>
        </div>
        <button class="btn btn-primary">Atualizar</button>
        <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
