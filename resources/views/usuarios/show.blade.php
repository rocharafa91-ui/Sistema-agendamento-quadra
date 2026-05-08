@extends('layout')
@section('titulo', 'Usuário')
@section('conteudo')
    <h1>{{ $usuario->nome }}</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $usuario->id }}</p>
            <p><strong>E-mail:</strong> {{ $usuario->email }}</p>
            <p><strong>Telefone:</strong> {{ $usuario->telefone }}</p>
        </div>
    </div>

    <h3 class="mt-4">Reservas deste usuário</h3>
    <table class="table">
        <thead><tr><th>#</th><th>Data</th><th>Horário</th><th>Local</th><th>Status</th></tr></thead>
        <tbody>
            @forelse($usuario->reservas as $r)
                <tr>
                    <td>{{ $r->id }}</td>
                    <td>{{ $r->data->format('d/m/Y') }}</td>
                    <td>{{ $r->horario }}</td>
                    <td>
                        @if($r->quadra) Quadra: {{ $r->quadra->nome }}
                        @elseif($r->espacoLazer) Espaço: {{ $r->espacoLazer->nome }}
                        @endif
                    </td>
                    <td><span class="badge bg-secondary">{{ $r->status }}</span></td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Sem reservas.</td></tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-warning">Editar</a>
    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Voltar</a>
@endsection
