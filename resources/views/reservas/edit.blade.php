@extends('layout')
@section('titulo', 'Editar Reserva')
@section('conteudo')
    <h1>Editar Reserva #{{ $reserva->id }}</h1>
    <form action="{{ route('reservas.update', $reserva) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Usuário</label>
            <select name="usuario_id" class="form-select" required>
                @foreach($usuarios as $u)
                    <option value="{{ $u->id }}" @selected(old('usuario_id', $reserva->usuario_id) == $u->id)>{{ $u->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Quadra</label>
            <select name="quadra_id" class="form-select">
                <option value="">-- nenhuma --</option>
                @foreach($quadras as $q)
                    <option value="{{ $q->id }}" @selected(old('quadra_id', $reserva->quadra_id) == $q->id)>{{ $q->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Espaço de Lazer</label>
            <select name="espaco_lazer_id" class="form-select">
                <option value="">-- nenhum --</option>
                @foreach($espacos as $e)
                    <option value="{{ $e->id }}" @selected(old('espaco_lazer_id', $reserva->espaco_lazer_id) == $e->id)>{{ $e->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Data</label>
                <input type="date" name="data" class="form-control"
                       value="{{ old('data', $reserva->data->format('Y-m-d')) }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Horário</label>
                <input type="time" name="horario" class="form-control"
                       value="{{ old('horario', $reserva->horario) }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    @foreach($statusList as $s)
                        <option value="{{ $s }}" @selected(old('status', $reserva->status) == $s)>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button class="btn btn-primary">Atualizar</button>
        <a href="{{ route('reservas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
