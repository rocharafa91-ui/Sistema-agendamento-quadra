<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\BarController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\QuadraController;
use App\Http\Controllers\EspacoLazerController;
use App\Http\Controllers\ReservaController;

/*
|--------------------------------------------------------------------------
| ROTAS DA APLICAÇÃO — Sistema de Reservas
|--------------------------------------------------------------------------
|
| Cada Route::resource(...) cria automaticamente as 7 rotas do CRUD:
|   index, create, store, show, edit, update, destroy
| Rotas adicionais (confirmar/cancelar/alugar/comprar) são declaradas
| ANTES da resource para não conflitar com /{id}.
|
*/

// Página inicial
Route::get('/', fn() => view('home'))->name('home');

// CRUDs principais (resource controllers)
Route::resource('usuarios',      UsuarioController::class);
Route::resource('bars',          BarController::class);
Route::resource('quadras',       QuadraController::class);
Route::resource('equipamentos',  EquipamentoController::class);

// Espaços de lazer (parameter renomeado para 'espacos_lazer')
Route::resource('espacos_lazer', EspacoLazerController::class)
    ->parameters(['espacos_lazer' => 'espacos_lazer']);

// Produtos + ação extra "comprar"
Route::post('produtos/{produto}/comprar', [ProdutoController::class, 'comprar'])
    ->name('produtos.comprar');
Route::resource('produtos', ProdutoController::class);

// Equipamentos: alugar / devolver
Route::post('equipamentos/{equipamento}/alugar',   [EquipamentoController::class, 'alugar'])
    ->name('equipamentos.alugar');
Route::post('equipamentos/{equipamento}/devolver', [EquipamentoController::class, 'devolver'])
    ->name('equipamentos.devolver');

// Reservas + ações extras (confirmar/cancelar)
Route::post('reservas/{reserva}/confirmar', [ReservaController::class, 'confirmar'])
    ->name('reservas.confirmar');
Route::post('reservas/{reserva}/cancelar',  [ReservaController::class, 'cancelar'])
    ->name('reservas.cancelar');
Route::resource('reservas', ReservaController::class);
