@extends('layout')
@section('titulo', 'Reserva')
@section('conteudo')
    <h1>Reserva #{{ $reserva->id }}</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Usuário:</strong> {{ $reserva->usuario->nome ?? '—' }}</p>
            <p><strong>Data:</strong> {{ $reserva->data->format('d/m/Y') }}</p>
            <p><strong>Horário:</strong> {{ $reserva->horario }}</p>
            <p><strong>Status:</strong> {{ $reserva->status }}</p>
            @if($reserva->quadra)
                <p><strong>Quadra:</strong> {{ $reserva->quadra->nome }} ({{ $reserva->quadra->tipo }})</p>
            @endif
            @if($reserva->espacoLazer)
                <p><strong>Espaço:</strong> {{ $reserva->espacoLazer->nome }} (capacidade {{ $reserva->espacoLazer->capacidade }})</p>
            @endif
        </div>
    </div>
    <div class="mt-3">
        <a href="{{ route('reservas.edit', $reserva) }}" class="btn btn-warning">Editar</a>
        <a href="{{ route('reservas.index') }}" class="btn btn-secondary">Voltar</a>
    </div>
@endsection
