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
        $permisos = ['Crear roles', 'Editar roles', 'Eliminar roles', 'Listar roles'];

        for ($i = 0; $i < count($permisos); $i++) { 
            DB::table('permisos')->insert([
                'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'nombre' => $permisos[$i],
            ]);
        }
    }
}
