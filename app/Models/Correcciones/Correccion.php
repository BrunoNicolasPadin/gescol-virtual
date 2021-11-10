<?php

namespace App\Models\Correcciones;

use App\Models\Entregas\Entrega;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Correccion extends Model
{
    use Uuids;

    protected $table = 'correcciones';
    protected $fillable = [
        'archivo',
    ];

    public function entrega()
    {
        return $this->belongsTo(Entrega::class);
    }
}
