<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\EventoUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {

    public function index() {
        $convites = EventoUser::addSelect([
            'descricao'   => Evento::select('descricao')->whereColumn('id', 'eventos_users.evento_id'),
            'data_evento' => Evento::select('data_evento')->whereColumn('id', 'eventos_users.evento_id'),
            'autor'       => User::select('name')->whereColumn('id', 'eventos_users.user_id'),
        ])->where([['user_id', Auth::user()['id']], ['convite_aceito', 'aguardando']])->get()->toArray();
        return view('dashboard', compact('convites'));
    }

}
