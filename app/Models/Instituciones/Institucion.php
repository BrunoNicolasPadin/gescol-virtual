<?php

namespace App\Models\Instituciones;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    use Uuids;

    protected $table = 'instituciones';
    protected $fillable = [
        'nombre',
        'claveDeAcceso',
    ];

    public function user()
    {
        return $this->belongsTo(Institucion::class);
    }
}
