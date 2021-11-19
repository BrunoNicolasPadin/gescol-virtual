<?php

namespace Database\Factories\Roles;

use App\Models\Roles\Rol;
use App\Models\Roles\RolUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RolUserFactory extends Factory
{
    protected $model = RolUser::class;

    public function definition()
    {
        return [
            'rol_id' => Rol::factory(),
            'user_id' => User::factory()->create(['institucion' => 0]),
        ];
    }
}
