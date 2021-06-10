<?php

namespace App\Http\Controllers\Evento;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\EventoUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $eventos_convidados = DB::table('eventos_users')
            ->join('eventos', 'eventos_users.evento_id', '=', 'eventos.id')
            ->join('users', 'eventos.autor_id', '=', 'users.id')
            ->select('eventos_users.*', 'eventos.descricao', 'eventos.data_evento', 'users.name as autor')
            ->where([['user_id', Auth::user()['id']], ['convite_aceito', 'aguardando']])
            ->get();
        return view('evento.meus-eventos', compact('meus_eventos', 'eventos_convidados'));
    }

}
