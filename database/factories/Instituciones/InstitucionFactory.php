<?php

namespace Database\Factories\Instituciones;

use App\Models\Instituciones\Institucion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstitucionFactory extends Factory
{
    protected $model = Institucion::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->name(),
            'user_id' => User::factory()->create(),
        ];
    }
}
