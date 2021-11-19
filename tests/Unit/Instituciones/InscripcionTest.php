<?php

namespace Tests\Unit\Instituciones;

use App\Models\Instituciones\Institucion;
use App\Models\Permisos\Permiso;
use App\Models\Roles\PermisoRol;
use App\Models\Roles\Rol;
use App\Models\Roles\RolUser;
use App\Models\User;
use Tests\TestCase;

class InscripcionTest extends TestCase
{
    public function test_permission_for_register_in_an_institucion()
    {
        $userConPermiso = User::factory()->create();
        $userSinPermiso = User::factory()->create();

        $institucion = Institucion::factory()->create();

        $rolSinPermiso = Rol::factory()->create([
            'nombre' => 'Alumno',
            'institucion_id' => $institucion->id,
        ]);

        //Alumno
        RolUser::factory()->create([
            'rol_id' => $rolSinPermiso->id,
            'user_id' => $userSinPermiso->id,
        ]);

        /** @var \Illuminate\Contracts\Auth\Authenticatable $userConPermiso */
        $response = $this->actingAs($userConPermiso)->get(route('instituciones.inscripciones.create', $institucion->id));
        $response->assertStatus(200);

        /** @var \Illuminate\Contracts\Auth\Authenticatable $userSinPermiso */
        $response = $this->actingAs($userSinPermiso)->get(route('instituciones.inscripciones.create', $institucion->id));
        $response->assertStatus(403);
    }

    public function test_permission_for_edit_an_inscripcion()
    {
        $userConPermiso = User::factory()->create();
        $userSinPermiso = User::factory()->create();

        $institucion = Institucion::factory()->create();

        $rolConPermiso = Rol::factory()->create([
            'nombre' => 'Directivo',
            'institucion_id' => $institucion->id,
        ]);
        $rolSinPermiso = Rol::factory()->create([
            'nombre' => 'Alumno',
            'institucion_id' => $institucion->id,
        ]);

        //Directivo
        $rolUserDirectivo = RolUser::factory()->create([
            'rol_id' => $rolConPermiso->id,
            'user_id' => $userConPermiso->id,
        ]);
        //Alumno
        $rolUserAlumno = RolUser::factory()->create([
            'rol_id' => $rolSinPermiso->id,
            'user_id' => $userSinPermiso->id,
        ]);

        $permisoEditarInscripcion = Permiso::where('nombre', 'Inscripciones: editar')->first();

        //Permiso de editar inscripciones al directivo
        PermisoRol::factory()->create([
            'permiso_id' => $permisoEditarInscripcion->id,
            'rol_id' => $rolConPermiso->id,
        ]);

        //Permitir editar a otros porque tiene el permiso
        /** @var \Illuminate\Contracts\Auth\Authenticatable $userConPermiso */
        $response = $this->actingAs($userConPermiso)->get(route('instituciones.inscripciones.edit', [$institucion->id, $rolUserAlumno->id]));
        $response->assertStatus(200);

        //Permitir editarse a uno mismo
        /** @var \Illuminate\Contracts\Auth\Authenticatable $userSinPermiso */
        $response = $this->actingAs($userSinPermiso)->get(route('instituciones.inscripciones.edit', [$institucion->id, $rolUserAlumno->id]));
        $response->assertStatus(200);

        //No permitir editar a otros sin tener permiso
        /** @var \Illuminate\Contracts\Auth\Authenticatable $userSinPermiso */
        $response = $this->actingAs($userSinPermiso)->get(route('instituciones.inscripciones.edit', [$institucion->id, $rolUserDirectivo->id]));
        $response->assertStatus(403);
    }

    public function test_permission_for_delete_an_inscripcion()
    {
        $userConPermiso = User::factory()->create();
        $userSinPermiso = User::factory()->create();

        $institucion = Institucion::factory()->create();

        $rolConPermiso = Rol::factory()->create([
            'nombre' => 'Directivo',
            'institucion_id' => $institucion->id,
        ]);
        $rolSinPermiso = Rol::factory()->create([
            'nombre' => 'Alumno',
            'institucion_id' => $institucion->id,
        ]);

        //Directivo
        $rolUserDirectivo = RolUser::factory()->create([
            'rol_id' => $rolConPermiso->id,
            'user_id' => $userConPermiso->id,
        ]);
        //Alumno
        $rolUserAlumno = RolUser::factory()->create([
            'rol_id' => $rolSinPermiso->id,
            'user_id' => $userSinPermiso->id,
        ]);

        $permisoEliminarInscripcion = Permiso::where('nombre', 'Inscripciones: eliminar')->first();

        //Permiso de eliminar inscripciones al directivo
        PermisoRol::factory()->create([
            'permiso_id' => $permisoEliminarInscripcion->id,
            'rol_id' => $rolConPermiso->id,
        ]);

        //Permitir eliminar a otros porque tiene el permiso
        /** @var \Illuminate\Contracts\Auth\Authenticatable $userConPermiso */
        $response = $this->actingAs($userConPermiso)->delete(route('instituciones.inscripciones.destroy', [$institucion->id, $rolUserAlumno->id]));
        $response->assertRedirect(route('panel.mostrarInicio'));

        //No permitir eliminar a otros sin tener permiso
        /** @var \Illuminate\Contracts\Auth\Authenticatable $userSinPermiso */
        $response = $this->actingAs($userSinPermiso)->delete(route('instituciones.inscripciones.destroy', [$institucion->id, $rolUserDirectivo->id]));
        $response->assertStatus(403);
    }
}
