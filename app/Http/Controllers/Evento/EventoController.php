<?php

namespace App\Http\Controllers\Evento;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\EventoUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EventoController extends Controller {

    public function adicionar(Request $request) {
        $user = Auth::user()->toArray();
        $requestData = $request->toArray();
        if ($requestData) {
            Validator::make($requestData, [
                'descricao1' => ['required', 'string', 'max:255'],
                'data_evento' => ['required', 'date'],
                'users.*' => ['required', 'integer'],
            ]);
            $evento = Evento::create([
                'autor_id'    => $user['id'],
                'descricao'   => $requestData['descricao'],
                'data_evento' => $requestData['data_evento'],
            ]);
            foreach ($requestData['users'] as $valueUser) {
                EventoUser::firstOrCreate([
                    'evento_id'    => $evento->id,
                    'user_id'   => $valueUser,
                ]);
            }
            return redirect()->route('dashboard')->with([
                'avisos' => 'Evento criado!',
            ]);
        }
        $users = User::where('id', '!=', $user['id'])->get()->toArray();
        return view('evento.adicionar', compact('users'));
    }

    public function excluir($id=null) {
        $aviso = null;
        if (!empty($id)) {
            /*
             * verificar se id esta vinculado ao usuario
             * [...]
             */
            Evento::destroy($id);
        }
        return redirect()->route('evento.meus-eventos')->with([
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
