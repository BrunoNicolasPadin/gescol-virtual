<?php

namespace Tests\Unit\Materias;

use App\Models\Cursos\Curso;
use App\Models\Instituciones\Institucion;
use App\Models\Materias\Materia;
use App\Models\Roles\RolUser;
use Tests\TestCase;

class MateriaTest extends TestCase
{
    public function test_permission_for_list_materias()
    {
        $institucion = Institucion::factory()->create();
        $institucion->with('user')->first();

        $rolUserSinPermisos = RolUser::factory()->create();
        $rolUserSinPermisos->with('user')->first();

        $curso = Curso::factory()->create([
            'institucion_id' => $institucion->id,
        ]);

        //Permitir listar materias ya que tiene el permiso
        $response = $this->actingAs($institucion->user)->get(route('materias.index', [$institucion->id, $curso->id]));
        $response->assertStatus(200);

        //No permitir listar materias
        $response = $this->actingAs($rolUserSinPermisos->user)->get(route('materias.index', [$institucion->id, $curso->id]));
        $response->assertStatus(403);
    }

    public function test_permission_for_create_a_materia()
    {
        $institucion = Institucion::factory()->create();
        $institucion->with('user')->first();

        $rolUserSinPermisos = RolUser::factory()->create();
        $rolUserSinPermisos->with('user')->first();

        $curso = Curso::factory()->create([
            'institucion_id' => $institucion->id,
        ]);

        //Permitir crear materia ya que tiene el permiso
        $response = $this->actingAs($institucion->user)->get(route('materias.create', [$institucion->id, $curso->id]));
        $response->assertStatus(200);

        //No permitir crear materia
        $response = $this->actingAs($rolUserSinPermisos->user)->get(route('materias.create', [$institucion->id, $curso->id]));
        $response->assertStatus(403);
    }

    public function test_permission_for_edit_a_materia()
    {
        $institucion = Institucion::factory()->create();
        $institucion->with('user')->first();

        $rolUserSinPermisos = RolUser::factory()->create();
        $rolUserSinPermisos->with('user')->first();

        $materia = Materia::factory()->create();

        //Permitir editar materia ya que tiene el permiso
        $response = $this->actingAs($institucion->user)->get(route('materias.edit', [$institucion->id, $materia->curso_id, $materia->id]));
        $response->assertStatus(200);

        //No permitir editar materia
        $response = $this->actingAs($rolUserSinPermisos->user)->get(route('materias.edit', [$institucion->id, $materia->curso_id, $materia->id]));
        $response->assertStatus(403);
    }

    public function test_permission_for_delete_a_materia()
    {
        $institucion = Institucion::factory()->create();
        $institucion->with('user')->first();

        $rolUserSinPermisos = RolUser::factory()->create();
        $rolUserSinPermisos->with('user')->first();

        $curso = Curso::factory()->create([
            'institucion_id' => $institucion->id,
        ]);

        $materia = Materia::factory()->create();
        $materiaNoEliminable = Materia::factory()->create();

        //Permitir eliminar materia ya que tiene el permiso
        $response = $this->actingAs($institucion->user)->delete(route('materias.destroy', [$institucion->id, $curso->id, $materia->id]));
        $response->assertRedirect(route('materias.index', [$institucion->id, $curso->id]));

        //No permitir eliminar materias
        $response = $this->actingAs($rolUserSinPermisos->user)->delete(route('materias.destroy', [$institucion->id, $curso->id, $materiaNoEliminable->id]));
        $response->assertStatus(403);
    }
}
