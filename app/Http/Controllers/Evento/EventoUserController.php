<?php

namespace App\Http\Controllers\Evento;

use App\Http\Controllers\Controller;
use App\Models\EventoUser;

class EventoUserController extends Controller {

        public function editar($id=null, $status=null) {
        $aviso = null;
        if (!empty($id) && !empty($status)) {
            /*
             * verificar se id esta vinculado ao usuario
             * [...]
             */
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
