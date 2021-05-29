<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Evento\EventoController;
use App\Http\Controllers\Evento\EventoUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/login');

Route::group(['prefix'=>'dashboard', 'middleware'=>'auth'], function (){
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::match(['get', 'post'],'/evento/adicionar', [EventoController::class, 'adicionar'])->name('evento.adicionar');
    Route::get('/evento/editar/{id?}/{status?}', [EventoUserController::class, 'editar'])->name('evento-user.editar');
    Route::get('/evento/excluir/{id?}', [EventoController::class, 'excluir'])->name('evento.excluir');
    Route::match(['get', 'post'],'/evento/meus-eventos', [EventoController::class, 'meusEventos'])->name('evento.meus-eventos');
});

require __DIR__.'/auth.php';
