<?php

namespace Tests\Unit\Roles;

use App\Models\Instituciones\Institucion;
use App\Models\Roles\Rol;
use App\Models\User;
use Tests\TestCase;

class RolTest extends TestCase
{
    public function test_permission_for_create_a_rol()
    {
        $institucionConPermiso = Institucion::factory()->create();
        $institucionConPermiso->with('user')->first();

        $userSinPermiso = User::factory()->create([
            'institucion' => 0,
        ]);

        $response = $this->actingAs($institucionConPermiso->user)->get(route('roles.create', $institucionConPermiso->id));
        $response->assertStatus(200);

        /** @var \Illuminate\Contracts\Auth\Authenticatable $userSinPermiso */
        $response = $this->actingAs($userSinPermiso)->get(route('roles.create', $institucionConPermiso->id));
        $response->assertStatus(403);
    }

    public function test_permission_for_edit_a_rol()
    {
        $rol = Rol::factory()->create();
        $rol = $rol->with('institucion.user')->first();

        $userSinPermiso = User::factory()->create([
            'institucion' => 0,
        ]);

        $response = $this->actingAs($rol->institucion->user)->get(route('roles.edit', [$rol->institucion_id, $rol->id]));
        $response->assertStatus(200);

        /** @var \Illuminate\Contracts\Auth\Authenticatable $userSinPermiso */
        $response = $this->actingAs($userSinPermiso)->get(route('roles.edit', [$rol->institucion_id, $rol->id]));
        $response->assertStatus(403);
    }

    public function test_permission_for_delete_a_rol()
    {
        $rol = Rol::factory()->create();
        $rol = $rol->with('institucion.user')->first();

        $rolEliminable = Rol::factory()->create();
        $rolEliminable = $rolEliminable->with('institucion.user')->first();

        /* $userSinPermiso = User::factory()->create([
            'institucion' => 0,
        ]); */

        $response = $this->actingAs($rol->institucion->user)->delete(route('roles.destroy', [$rol->institucion_id, $rol->id]));
        $response->assertRedirect(route('panel.mostrarRoles', $rol->institucion_id));

        /** @var \Illuminate\Contracts\Auth\Authenticatable $userSinPermiso */
        /* $response = $this->actingAs($userSinPermiso)->delete(route('roles.destroy', [$rolEliminable->institucion_id, $rolEliminable->id]));
        $response->assertStatus(403); */
    }
}
