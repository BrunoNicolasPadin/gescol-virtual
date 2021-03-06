<?php

namespace App\Models\Roles;

use App\Models\User;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolUser extends Model
{
    use Uuids;
    use HasFactory;

    protected $table = 'roles_users';

    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
