<?php

namespace App\Models\Archivos;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    use Uuids;

    protected $table = 'archivos';

    protected $fillable = [
        'fileable_type',
        'fileable_id',
        'archivo',
    ];

    public function fileable()
    {
        return $this->morphTo();
    }
}
