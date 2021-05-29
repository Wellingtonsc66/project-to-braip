<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\EventoUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {

    public function index() {
        $user = Auth::user()->toArray();
        $convites = EventoUser::where([['user_id', $user['id']], ['convite_aceito', 'aguardando']])->get()->toArray();
        foreach ($convites as $key=>$value) {
            $evento = Evento::find($value['evento_id'])->first()->toArray();
            $autor = User::find($value['user_id'])->first()->toArray();
            $convites[$key]['eventoId'] = $evento['id'];
            $convites[$key]['data_evento'] = $evento['data_evento'];
            $convites[$key]['descricao'] = $evento['descricao'];
            $convites[$key]['autor'] = $autor['name'];
        }
        return view('dashboard', compact('convites'));
    }

}
