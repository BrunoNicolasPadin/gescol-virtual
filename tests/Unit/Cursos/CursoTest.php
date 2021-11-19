<?php

namespace Tests\Unit\Cursos;

use App\Models\Cursos\Curso;
use App\Models\Instituciones\Institucion;
use App\Models\Permisos\Permiso;
use App\Models\Roles\PermisoRol;
use App\Models\Roles\Rol;
use App\Models\Roles\RolUser;
use App\Models\User;
use Tests\TestCase;

class CursoTest extends TestCase
{
    public function test_permission_for_crete_a_curso()
    {
        $institucion = Institucion::factory()->create();
        $institucion->with('user')->first();

        $rolUserSinPermisos = RolUser::factory()->create();
        $rolUserSinPermisos->with('user')->first();

        //Permitir crear curso ya que tiene el permiso
        $response = $this->actingAs($institucion->user)->get(route('cursos.create', $institucion->id));
        $response->assertStatus(200);

        //No permitir crear curso
        $response = $this->actingAs($rolUserSinPermisos->user)->get(route('cursos.create', $institucion->id));
        $response->assertStatus(403);
    }

    public function test_permission_for_edit_a_curso()
    {
        $institucion = Institucion::factory()->create();
        $institucion->with('user')->first();

        $curso = Curso::factory()->create([
            'institucion_id' => $institucion->id,
        ]);

        $rolUserSinPermisos = RolUser::factory()->create();
        $rolUserSinPermisos->with('user')->first();

        //Permitir editar curso ya que tiene el permiso
        $response = $this->actingAs($institucion->user)->get(route('cursos.edit', [$institucion->id, $curso->id]));
        $response->assertStatus(200);

        //No permitir editar curso
        $response = $this->actingAs($rolUserSinPermisos->user)->get(route('cursos.edit', [$institucion->id, $curso->id]));
        $response->assertStatus(403);
    }

    public function test_permission_for_delete_a_curso()
    {
        $institucion = Institucion::factory()->create();
        $institucion->with('user')->first();

        $curso = Curso::factory()->create([
            'institucion_id' => $institucion->id,
        ]);

        $segundoCurso = Curso::factory()->create([
            'institucion_id' => $institucion->id,
        ]);

        $rolUserSinPermisos = RolUser::factory()->create();
        $rolUserSinPermisos->with('user')->first();

        //Permitir eliminar curso ya que tiene el permiso
        $response = $this->actingAs($institucion->user)->delete(route('cursos.destroy', [$institucion->id, $curso->id]));
        $response->assertRedirect(route('cursos.index', $institucion->id));

        //No permitir eliminar cursos
        $response = $this->actingAs($rolUserSinPermisos->user)->delete(route('cursos.destroy', [$institucion->id, $segundoCurso->id]));
        $response->assertStatus(403);
    }
}
