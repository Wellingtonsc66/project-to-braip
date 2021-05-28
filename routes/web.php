<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Evento\EventoController;

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
    Route::get('/', function () {
        $user = Illuminate\Support\Facades\Auth::user()->toArray();
        $convites = \App\Models\EventoUser::where([['user_id', $user['id']], ['convite_aceito', 'aguardando']])->get()->toArray();
        foreach ($convites as $key=>$value) {
            $evento = \App\Models\Evento::find($value['evento_id'])->first()->toArray();
            $autor = \App\Models\User::find($value['user_id'])->first()->toArray();
            $convites[$key]['eventoId'] = $evento['id'];
            $convites[$key]['data_evento'] = $evento['data_evento'];
            $convites[$key]['descricao'] = $evento['descricao'];
            $convites[$key]['autor'] = $autor['name'];
        }
        return view('dashboard', compact('convites'));
    })->name('dashboard');

    Route::match(['get', 'post'],'/evento/adicionar', [EventoController::class, 'adicionar'])->name('evento.adicionar');
    Route::get('/evento/editar-evento-user/{id?}/{status?}', [EventoController::class, 'editarEventoUser'])->name('evento.editar-evento-user');
    Route::get('/evento/excluir/{id?}', [EventoController::class, 'excluir'])->name('evento.excluir');
    Route::match(['get', 'post'],'/evento/meus-eventos', [EventoController::class, 'meusEventos'])->name('evento.meus-eventos');
});

require __DIR__.'/auth.php';
