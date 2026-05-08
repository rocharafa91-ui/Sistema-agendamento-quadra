@extends('layout')
@section('titulo', 'Reservas')
@section('conteudo')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Reservas</h1>
        <a href="{{ route('reservas.create') }}" class="btn btn-success">+ Nova Reserva</a>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr><th>#</th><th>Usuário</th><th>Data</th><th>Horário</th><th>Local</th><th>Status</th><th width="320">Ações</th></tr>
        </thead>
        <tbody>
            @forelse($reservas as $reserva)
                <tr>
                    <td>{{ $reserva->id }}</td>
                    <td>{{ $reserva->usuario->nome ?? '—' }}</td>
                    <td>{{ $reserva->data->format('d/m/Y') }}</td>
                    <td>{{ $reserva->horario }}</td>
                    <td>
                        @if($reserva->quadra)
                            <span class="badge bg-info">Quadra: {{ $reserva->quadra->nome }}</span>
                        @elseif($reserva->espacoLazer)
                            <span class="badge bg-warning text-dark">Espaço: {{ $reserva->espacoLazer->nome }}</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $cor = match($reserva->status) {
                                'confirmada' => 'success',
                                'cancelada' => 'danger',
                                default => 'secondary',
                            };
                        @endphp
                        <span class="badge bg-{{ $cor }}">{{ $reserva->status }}</span>
                    </td>
                    <td>
                        <a href="{{ route('reservas.show', $reserva) }}" class="btn btn-info btn-sm">Ver</a>
                        @if($reserva->status === 'pendente')
                            <form action="{{ route('reservas.confirmar', $reserva) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-success btn-sm">Confirmar</button>
                            </form>
                        @endif
                        @if($reserva->status !== 'cancelada')
                            <form action="{{ route('reservas.cancelar', $reserva) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-warning btn-sm">Cancelar</button>
                            </form>
                        @endif
                        <form action="{{ route('reservas.destroy', $reserva) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Excluir reserva?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">Nenhuma reserva.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $reservas->links() }}
@endsection
