<?php

namespace App\Http\Controllers\Evento;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\EventoUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventoController extends Controller {

    public function adicionar(Request $request) {
        $requestData = $request->toArray();
        if ($requestData) {
            $request->validate([
                'descricao'   => ['required', 'string', 'max:255'],
                'data_evento' => ['required', 'date'],
                'users.*'     => ['required', 'integer'],
            ]);
            $evento = Evento::create([
                'autor_id'    => Auth::user()['id'],
                'descricao'   => $requestData['descricao'],
                'data_evento' => $requestData['data_evento'],
            ]);
            foreach ($requestData['users'] as $valueUser) {
                EventoUser::create([
                    'evento_id' => $evento->id,
                    'user_id'   => $valueUser,
                ]);
            }
            return redirect()->route('dashboard')->with([
                'avisos' => 'Evento criado!',
            ]);
        }
        $users = User::where('id', '!=', Auth::user()['id'])->get()->toArray();
        return view('evento.adicionar', compact('users'));
    }

    public function excluir($id=null) {
        if (Evento::where([['autor_id', Auth::user()['id']], ['id', $id]])->firstOrFail()) {
            Evento::destroy($id);
        }
        return back()->with([
            'avisos' => 'Evento excluido!',
        ]);
    }

    public function meusEventos() {
        $user = Auth::user()->toArray();
        $meus_eventos = Evento::where('autor_id', $user['id'])->get()->toArray();
        $eventos_convidados = EventoUser::addSelect([
            'descricao'   => Evento::select('descricao')->whereColumn('id', 'eventos_users.evento_id'),
            'data_evento' => Evento::select('data_evento')->whereColumn('id', 'eventos_users.evento_id'),
            'name'        => User::select('name')->whereColumn('id', 'eventos_users.user_id'),
        ])->where([['user_id', $user['id']], ['convite_aceito', '!=', 'aguardando']])->get()->toArray();
        return view('evento.meus-eventos', compact('meus_eventos', 'eventos_convidados'));
    }

}
