@extends('layout')
@section('titulo', 'Espaço de Lazer')
@section('conteudo')
    <h1>{{ $espaco->nome }}</h1>
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Capacidade:</strong> {{ $espaco->capacidade }} pessoa(s)</p>
            <p><strong>Disponível:</strong> {{ $espaco->disponivel ? 'Sim' : 'Não' }}</p>
        </div>
    </div>

    <h3>Reservas deste espaço</h3>
    <table class="table">
        <thead><tr><th>#</th><th>Usuário</th><th>Data</th><th>Horário</th><th>Status</th></tr></thead>
        <tbody>
            @forelse($espaco->reservas as $r)
                <tr>
                    <td>{{ $r->id }}</td>
                    <td>{{ $r->usuario->nome ?? '—' }}</td>
                    <td>{{ $r->data->format('d/m/Y') }}</td>
                    <td>{{ $r->horario }}</td>
                    <td>{{ $r->status }}</td>
                </tr>
            @empty<tr><td colspan="5" class="text-center">Sem reservas.</td></tr>@endforelse
        </tbody>
    </table>

    <a href="{{ route('espacos_lazer.edit', $espaco) }}" class="btn btn-warning">Editar</a>
    <a href="{{ route('espacos_lazer.index') }}" class="btn btn-secondary">Voltar</a>
@endsection
