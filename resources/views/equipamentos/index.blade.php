@extends('layout')
@section('titulo', 'Equipamentos')
@section('conteudo')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Equipamentos</h1>
        <a href="{{ route('equipamentos.create') }}" class="btn btn-success">+ Novo Equipamento</a>
    </div>
    <table class="table table-striped table-bordered">
        <thead class="table-dark"><tr><th>ID</th><th>Nome</th><th>Tipo</th><th>Disponível</th><th width="320">Ações</th></tr></thead>
        <tbody>
            @forelse($equipamentos as $eq)
                <tr>
                    <td>{{ $eq->id }}</td>
                    <td>{{ $eq->nome }}</td>
                    <td>{{ $eq->tipo }}</td>
                    <td>{!! $eq->disponivel ? '<span class="badge bg-success">Sim</span>' : '<span class="badge bg-warning text-dark">Alugado</span>' !!}</td>
                    <td>
                        <a href="{{ route('equipamentos.edit', $eq) }}" class="btn btn-warning btn-sm">Editar</a>
                        @if($eq->disponivel)
                            <form action="{{ route('equipamentos.alugar', $eq) }}" method="POST" class="d-inline">
                                @csrf<button class="btn btn-primary btn-sm">Alugar</button>
                            </form>
                        @else
                            <form action="{{ route('equipamentos.devolver', $eq) }}" method="POST" class="d-inline">
                                @csrf<button class="btn btn-success btn-sm">Devolver</button>
                            </form>
                        @endif
                        <form action="{{ route('equipamentos.destroy', $eq) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir?')">
                            @csrf @method('DELETE')<button class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty<tr><td colspan="5" class="text-center">Nenhum equipamento.</td></tr>@endforelse
        </tbody>
    </table>
    {{ $equipamentos->links() }}
@endsection
