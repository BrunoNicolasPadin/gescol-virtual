<?php

namespace Database\Factories\Cursos;

use App\Models\Cursos\Curso;
use Illuminate\Database\Eloquent\Factories\Factory;

class CursoFactory extends Factory
{
    protected $model = Curso::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->name(),
        ];
    }
}
