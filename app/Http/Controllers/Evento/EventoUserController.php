<?php

namespace App\Http\Controllers\Evento;

use App\Http\Controllers\Controller;
use App\Models\EventoUser;
use Illuminate\Support\Facades\Auth;

class EventoUserController extends Controller {

        public function editar($id=null, $status=null) {
        if (EventoUser::where([['user_id', Auth::user()['id']], ['id', $id], ['convite_aceito', 'aguardando']])->firstOrFail()) {
            if (strcasecmp($status, 'aceitar') == 0) {
                $status = 'sim';
                $aviso = 'Você aceitou participar do evento.';
            } else if (strcasecmp($status, 'recusar') == 0) {
                $status = 'nao';
                $aviso = 'Você recusou participar do evento.';
            }
            EventoUser::where('id', $id)->update([
                'convite_aceito' => $status,
            ]);
        }
        return redirect()->route('dashboard')->with([
            'avisos' => $aviso,
        ]);
    }

}
