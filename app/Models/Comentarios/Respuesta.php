<?php

namespace App\Models\Comentarios;

use App\Models\User;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use Uuids;

    protected $table = 'respuestas';

    protected $fillable = [
        'contenido',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comentario()
    {
        return $this->belongsTo(Comentario::class);
    }
}
