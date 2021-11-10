<?php

namespace App\Models\Comentarios;

use App\Models\User;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use Uuids;

    protected $with = ['user'];

    protected $table = 'comentarios';

    protected $fillable = [
        'commentable_type',
        'commentable_id',
        'contenido',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}
