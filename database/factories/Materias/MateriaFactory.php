<?php

namespace Database\Factories\Materias;

use App\Models\Cursos\Curso;
use App\Models\Materias\Materia;
use Illuminate\Database\Eloquent\Factories\Factory;

class MateriaFactory extends Factory
{
    protected $model = Materia::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->name(),
            'curso_id' => Curso::factory(),
        ];
    }
}
