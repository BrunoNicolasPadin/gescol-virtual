<?php

namespace App\Models\Instituciones;

use App\Models\User;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    use Uuids;
    use HasFactory;

    protected $table = 'instituciones';
    protected $fillable = [
        'nombre',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
