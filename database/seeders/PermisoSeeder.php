<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $secciones = [
            'Clases', 'Correcciones', 'Cursos', 'Entregas', 'Evaluaciones', 'Instituciones', 'Inscripciones', 'Materias', 'Docentes', 
            'Roles', 'Permisos de un rol', 'Archivos de evaluaciones', 'Archivos de entregas', 'Archivos de clases', 'Comentarios en evaluaciones', 
            'Comentarios en entregas', 'Comentarios en clases', 'Respuestas', 'Alumnos de la materia'
        ];
        $acciones = ['listar', 'ver', 'crear', 'editar', 'eliminar'];

        for ($i = 0; $i < count($secciones); $i++) { 
            for ($k = 0; $k < count($acciones); $k++) { 
                DB::table('permisos')->insert([
                    'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                    'nombre' => $secciones[$i] . ': ' . $acciones[$k],
                ]);
            }
        }
    }
}
