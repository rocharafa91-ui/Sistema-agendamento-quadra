@extends('layout')
@section('titulo', 'Nova Reserva')
@section('conteudo')
    <h1>Nova Reserva</h1>
    <form action="{{ route('reservas.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Usuário</label>
            <select name="usuario_id" class="form-select" required>
                <option value="">-- selecione --</option>
                @foreach($usuarios as $u)
                    <option value="{{ $u->id }}" @selected(old('usuario_id') == $u->id)>{{ $u->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Quadra (opcional)</label>
            <select name="quadra_id" class="form-select">
                <option value="">-- nenhuma --</option>
                @foreach($quadras as $q)
                    <option value="{{ $q->id }}" @selected(old('quadra_id') == $q->id)>{{ $q->nome }} ({{ $q->tipo }})</option>
                @endforeach
            </select>
            <small class="text-muted">Selecione uma quadra OU um espaço de lazer.</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Espaço de Lazer (opcional)</label>
            <select name="espaco_lazer_id" class="form-select">
                <option value="">-- nenhum --</option>
                @foreach($espacos as $e)
                    <option value="{{ $e->id }}" @selected(old('espaco_lazer_id') == $e->id)>{{ $e->nome }} (cap. {{ $e->capacidade }})</option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Data</label>
                <input type="date" name="data" class="form-control" value="{{ old('data') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Horário</label>
                <input type="time" name="horario" class="form-control" value="{{ old('horario') }}" required>
            </div>
        </div>

        <button class="btn btn-primary">Criar reserva</button>
        <a href="{{ route('reservas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
