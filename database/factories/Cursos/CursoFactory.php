<?php

namespace Database\Factories\Cursos;

use App\Models\Cursos\Curso;
use App\Models\Instituciones\Institucion;
use Illuminate\Database\Eloquent\Factories\Factory;

class CursoFactory extends Factory
{
    protected $model = Curso::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->name(),
            'institucion_id' => Institucion::factory(),
        ];
    }
}
