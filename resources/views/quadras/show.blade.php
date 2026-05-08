@extends('layout')
@section('titulo', 'Quadra')
@section('conteudo')
    <h1>{{ $quadra->nome }}</h1>
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Tipo:</strong> {{ $quadra->tipo }}</p>
            <p><strong>Disponível:</strong> {{ $quadra->disponivel ? 'Sim' : 'Não' }}</p>
        </div>
    </div>

    <h3>Reservas desta quadra</h3>
    <table class="table">
        <thead><tr><th>#</th><th>Usuário</th><th>Data</th><th>Horário</th><th>Status</th></tr></thead>
        <tbody>
            @forelse($quadra->reservas as $r)
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

    <a href="{{ route('quadras.edit', $quadra) }}" class="btn btn-warning">Editar</a>
    <a href="{{ route('quadras.index') }}" class="btn btn-secondary">Voltar</a>
@endsection
