<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\BarController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\QuadraController;
use App\Http\Controllers\EspacoLazerController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ROTAS DA APLICAÇÃO — Sistema de Reservas
|--------------------------------------------------------------------------
*/

// Página inicial (Dashboard com estatísticas e gráfico)
Route::get('/', [DashboardController::class, 'index'])->name('home');

// CRUDs principais
Route::resource('usuarios',      UsuarioController::class);
Route::resource('bars',          BarController::class);
Route::resource('quadras',       QuadraController::class);
Route::resource('equipamentos',  EquipamentoController::class);

// Espaços de lazer (parameter renomeado)
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

/*
|--------------------------------------------------------------------------
| ROTAS DE AUTENTICAÇÃO (Laravel Breeze)
|--------------------------------------------------------------------------
*/

// Rota de dashboard padrão do Breeze (acessada após login)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Perfil do usuário (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
