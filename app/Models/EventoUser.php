<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoUser extends Model
{
    use HasFactory;
    protected $table = 'eventos_users';
    protected $fillable = ['evento_id','user_id','convite_aceito','notificado'];
    public $timestamps = false;
}
