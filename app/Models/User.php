<?php

namespace App\Models;

use App\Models\Instituciones\Institucion;
use App\Models\Roles\RolUser;
use App\Traits\Uuids;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Uuids;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'institucion',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function obtenerPermisos($permiso)
    {
        return $this->hasMany(RolUser::class)
            ->join('roles', 'roles_users.rol_id', 'roles.id')
            ->join('permisos_roles', 'roles.id', 'permisos_roles.rol_id')
            ->join('permisos', 'permisos_roles.permiso_id', 'permisos.id')
            ->where('permisos.nombre', $permiso)
            ->exists();
    }

    public function verificarInstitucionCreada()
    {
        return $this->hasOne(Institucion::class)->exists();
    }
}
