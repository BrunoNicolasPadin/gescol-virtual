<?php

namespace Tests\Unit\Instituciones;

use App\Models\Instituciones\Institucion;
use App\Models\Roles\RolUser;
use App\Models\User;
use Tests\TestCase;

class InscripcionTest extends TestCase
{
    public function test_permission_for_register_in_an_institucion()
    {
        $institucion = Institucion::factory()->create();
        $institucion->with('user')->first();

        $userSinRol = User::factory()->create();

        $rolUserSinPermiso = RolUser::factory()->create();
        $rolUserSinPermiso->with('user', 'rol')->first();

        /** @var \Illuminate\Contracts\Auth\Authenticatable $userSinRol */
        $response = $this->actingAs($userSinRol)->get(route('instituciones.inscripciones.create', $institucion->id));
        $response->assertStatus(200);

        /** @var \Illuminate\Contracts\Auth\Authenticatable $userSinPermiso */
        $response = $this->actingAs($rolUserSinPermiso->user)->get(route('instituciones.inscripciones.create', $rolUserSinPermiso->rol->institucion_id));
        $response->assertStatus(403);
    }

    public function test_permission_for_edit_an_inscripcion()
    {
        $institucion = Institucion::factory()->create();
        $institucion->with('user.rolUser')->first();

        $rolUserSinPermisos = RolUser::factory()->create();
        $rolUserSinPermisos->with('user')->first();

        //Permitir editar a otros porque tiene el permiso
        /** @var \Illuminate\Contracts\Auth\Authenticatable $userConPermiso */
        $response = $this->actingAs($institucion->user)->get(route('instituciones.inscripciones.edit', [$institucion->id, $rolUserSinPermisos->id]));
        $response->assertStatus(200);

        //Permitir editarse a uno mismo
        $response = $this->actingAs($rolUserSinPermisos->user)->get(route('instituciones.inscripciones.edit', [$institucion->id, $rolUserSinPermisos->id]));
        $response->assertStatus(200);

        //No permitir editar a otros sin tener permiso
        /** @var \Illuminate\Contracts\Auth\Authenticatable $userSinPermiso */
        $response = $this->actingAs($rolUserSinPermisos->user)->get(route('instituciones.inscripciones.edit', [$institucion->id, $institucion->user->rolUser->id]));
        $response->assertStatus(403);
    }

    public function test_permission_for_delete_an_inscripcion()
    {
        $institucion = Institucion::factory()->create();
        $institucion->with('user.rolUser')->first();

        $rolUserSinPermisos = RolUser::factory()->create();
        $rolUserSinPermisos->with('user')->first();

        $rolEliminable = RolUser::factory()->create();
        $rolEliminable->with('user')->first();

        //Permitir eliminar a otros porque tiene el permiso
        /** @var \Illuminate\Contracts\Auth\Authenticatable $userConPermiso */
        $response = $this->actingAs($institucion->user)->delete(route('instituciones.inscripciones.destroy', [$institucion->id, $rolUserSinPermisos->id]));
        $response->assertRedirect(route('panel.mostrarInicio'));

        //Permitir eliminarse a uno mismo
        $response = $this->actingAs($rolEliminable->user)->delete(route('instituciones.inscripciones.destroy', [$institucion->id, $rolEliminable->id]));
        $response->assertRedirect(route('panel.mostrarInicio'));

        //No permitir editar a otros sin tener permiso
        /** @var \Illuminate\Contracts\Auth\Authenticatable $userSinPermiso */
        $response = $this->actingAs($rolUserSinPermisos->user)->delete(route('instituciones.inscripciones.destroy', [$institucion->id, $institucion->user->rolUser->id]));
        $response->assertStatus(403);
    }
}
