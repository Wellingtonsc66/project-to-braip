<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {

    public function index() {
        $convites = DB::table('eventos_users')
            ->join('eventos', 'eventos_users.evento_id', '=', 'eventos.id')
            ->join('users', 'eventos.autor_id', '=', 'users.id')
            ->select('eventos_users.*', 'eventos.descricao', 'eventos.data_evento', 'users.name as autor')
            ->where([['user_id', Auth::user()['id']], ['convite_aceito', 'aguardando']])
            ->get();
        $prox_eventos = DB::table('eventos_users')
            ->join('eventos', 'eventos_users.evento_id', '=', 'eventos.id')
            ->join('users', 'eventos.autor_id', '=', 'users.id')
            ->select('eventos_users.*', 'eventos.descricao', 'eventos.data_evento', 'users.name as autor')
            ->where([['user_id', Auth::user()['id']], ['convite_aceito', 'sim']])
            ->get();
        return view('dashboard', compact('convites', 'prox_eventos'));
    }

}
