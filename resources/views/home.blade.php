@extends('layout')

@section('titulo', 'Dashboard')

@section('conteudo')
    <h1 class="mb-4">Dashboard</h1>
    <p class="lead text-muted">Visão geral do Sistema de Reservas</p>

    {{-- Cards de estatísticas --}}
    <div class="row g-3 mt-3">
        <div class="col-md-3 col-sm-6">
            <div class="card border-primary h-100">
                <div class="card-body">
                    <h6 class="text-muted">Reservas Totais</h6>
                    <h2 class="text-primary mb-0">{{ $totais['reservas'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card border-success h-100">
                <div class="card-body">
                    <h6 class="text-muted">Usuários</h6>
                    <h2 class="text-success mb-0">{{ $totais['usuarios'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card border-info h-100">
                <div class="card-body">
                    <h6 class="text-muted">Quadras</h6>
                    <h2 class="text-info mb-0">{{ $totais['quadras'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card border-warning h-100">
                <div class="card-body">
                    <h6 class="text-muted">Espaços de Lazer</h6>
                    <h2 class="text-warning mb-0">{{ $totais['espacos'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-1">
        <div class="col-md-4">
            <div class="card border-secondary h-100">
                <div class="card-body">
                    <h6 class="text-muted">Equipamentos</h6>
                    <h3 class="mb-0">
                        {{ $totais['equipamentos'] }}
                        <small class="text-danger fs-6">({{ $equipamentosAlugados }} alugados)</small>
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-dark h-100">
                <div class="card-body">
                    <h6 class="text-muted">Bares</h6>
                    <h3 class="mb-0">{{ $totais['bars'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-danger h-100">
                <div class="card-body">
                    <h6 class="text-muted">Produtos</h6>
                    <h3 class="mb-0">
                        {{ $totais['produtos'] }}
                        @if($produtosEstoqueBaixo > 0)
                            <small class="text-danger fs-6">({{ $produtosEstoqueBaixo }} com estoque baixo)</small>
                        @endif
                    </h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Gráfico e próximas reservas --}}
    <div class="row g-3 mt-3">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Reservas por Status</h5>
                    <canvas id="graficoStatus" style="max-height: 280px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Próximas Reservas</h5>
                    @if($proximasReservas->isEmpty())
                        <p class="text-muted">Nenhuma reserva agendada para os próximos dias.</p>
                    @else
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Hora</th>
                                    <th>Usuário</th>
                                    <th>Local</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proximasReservas as $r)
                                    <tr>
                                        <td>{{ $r->data->format('d/m') }}</td>
                                        <td>{{ $r->horario }}</td>
                                        <td>{{ $r->usuario->nome ?? '—' }}</td>
                                        <td>
                                            @if($r->quadra) {{ $r->quadra->nome }}
                                            @elseif($r->espacoLazer) {{ $r->espacoLazer->nome }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Atalhos --}}
    <h3 class="mt-5 mb-3">Atalhos</h3>
    <div class="row g-3">
        <div class="col-md-3"><a href="{{ route('reservas.create') }}" class="btn btn-primary w-100">+ Nova Reserva</a></div>
        <div class="col-md-3"><a href="{{ route('usuarios.create') }}" class="btn btn-success w-100">+ Novo Usuário</a></div>
        <div class="col-md-3"><a href="{{ route('quadras.create') }}" class="btn btn-info w-100 text-white">+ Nova Quadra</a></div>
        <div class="col-md-3"><a href="{{ route('produtos.create') }}" class="btn btn-danger w-100">+ Novo Produto</a></div>
    </div>

    {{-- Chart.js via CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('graficoStatus').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Pendente', 'Confirmada', 'Cancelada'],
                datasets: [{
                    data: [
                        {{ $reservasPorStatus['pendente'] }},
                        {{ $reservasPorStatus['confirmada'] }},
                        {{ $reservasPorStatus['cancelada'] }}
                    ],
                    backgroundColor: ['#6c757d', '#198754', '#dc3545'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    </script>
@endsection
