<?php

namespace Tests\Unit;

use App\Models\Instituciones\Institucion;
use App\Models\Roles\Rol;
use App\Models\User;
use Tests\TestCase;

class RolTest extends TestCase
{
    public function test_permission_for_create_a_rol()
    {
        $userConPermiso = User::factory()
            ->has(Institucion::factory()->count(1), 'instituciones')
            ->create();

        $userSinPermiso = User::factory()->create();

        /** @var \Illuminate\Contracts\Auth\Authenticatable $userConPermiso */
        $response = $this->actingAs($userConPermiso)->get(route('roles.create', $userConPermiso->instituciones->id));
        $response->assertStatus(200);

        /** @var \Illuminate\Contracts\Auth\Authenticatable $userSinPermiso */
        $response = $this->actingAs($userSinPermiso)->get(route('roles.create', $userConPermiso->instituciones->id));
        $response->assertStatus(403);
    }

    public function test_permission_for_edit_a_rol()
    {
        $userConPermiso = User::factory()
            ->has(Institucion::factory()->count(1), 'instituciones')
            ->create();

        $userSinPermiso = User::factory()->create([
            'institucion' => 0,
        ]);

        $rol = Rol::factory()->create([
            'nombre' => 'Alumno',
            'institucion_id' => $userConPermiso->instituciones->id,
        ]);

        /** @var \Illuminate\Contracts\Auth\Authenticatable $userConPermiso */
        $response = $this->actingAs($userConPermiso)->get(route('roles.edit', [$userConPermiso->instituciones->id, $rol->id]));
        $response->assertStatus(200);

        /** @var \Illuminate\Contracts\Auth\Authenticatable $userSinPermiso */
        $response = $this->actingAs($userSinPermiso)->get(route('roles.edit', [$userConPermiso->instituciones->id, $rol->id]));
        $response->assertStatus(403);
    }

    public function test_permission_for_delete_a_rol()
    {
        $userConPermiso = User::factory()
            ->has(Institucion::factory()->count(1), 'instituciones')
            ->create();

        $userSinPermiso = User::factory()->create([
            'institucion' => 0,
        ]);

        $rol = Rol::factory(2)->create([
            'nombre' => 'Alumno',
            'institucion_id' => $userConPermiso->instituciones->id,
        ]);

        /** @var \Illuminate\Contracts\Auth\Authenticatable $userConPermiso */
        $response = $this->actingAs($userConPermiso)->delete(route('roles.destroy', [$userConPermiso->instituciones->id, $rol[0]->id]));
        $response->assertRedirect(route('panel.mostrarRoles', $userConPermiso->instituciones->id));

        /** @var \Illuminate\Contracts\Auth\Authenticatable $userSinPermiso */
        $response = $this->actingAs($userSinPermiso)->delete(route('roles.destroy', [$userConPermiso->instituciones->id, $rol[1]->id]));
        $response->assertStatus(403);
    }
}
