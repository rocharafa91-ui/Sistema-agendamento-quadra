@extends('layout')

@section('titulo', 'Início')

@section('conteudo')
    <h1 class="mb-4">Sistema de Reservas</h1>
    <p class="lead">Gerencie usuários, reservas, quadras, espaços de lazer, equipamentos, bares e produtos.</p>

    <div class="row g-3 mt-3">
        <div class="col-md-4">
            <a href="{{ route('reservas.index') }}" class="card text-decoration-none h-100">
                <div class="card-body">
                    <h5 class="card-title">Reservas</h5>
                    <p class="card-text text-muted">Criar e gerenciar reservas de quadras e espaços.</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('usuarios.index') }}" class="card text-decoration-none h-100">
                <div class="card-body">
                    <h5 class="card-title">Usuários</h5>
                    <p class="card-text text-muted">Cadastro e gestão dos usuários do clube.</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('quadras.index') }}" class="card text-decoration-none h-100">
                <div class="card-body">
                    <h5 class="card-title">Quadras</h5>
                    <p class="card-text text-muted">Quadras esportivas disponíveis para reserva.</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('espacos_lazer.index') }}" class="card text-decoration-none h-100">
                <div class="card-body">
                    <h5 class="card-title">Espaços de Lazer</h5>
                    <p class="card-text text-muted">Churrasqueiras, salões e demais espaços.</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('equipamentos.index') }}" class="card text-decoration-none h-100">
                <div class="card-body">
                    <h5 class="card-title">Equipamentos</h5>
                    <p class="card-text text-muted">Equipamentos para aluguel.</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('bars.index') }}" class="card text-decoration-none h-100">
                <div class="card-body">
                    <h5 class="card-title">Bares & Produtos</h5>
                    <p class="card-text text-muted">Bares do clube e produtos vendidos.</p>
                </div>
            </a>
        </div>
    </div>
@endsection
