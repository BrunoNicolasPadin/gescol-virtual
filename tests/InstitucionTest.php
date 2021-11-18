<?php

namespace Tests\Unit;

use App\Models\Instituciones\Institucion;
use App\Models\User;
use Tests\TestCase;

class InstitucionTest extends TestCase
{
    public function test_user_can_create_an_institucion()
    {
        $user = User::factory()->create();
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $response = $this->actingAs($user)->get(route('instituciones.create'));
        $response->assertStatus(200);
    }

    public function test_user_cant_create_an_institucion()
    {
        $user = User::factory()->create([
            'institucion' => 0,
        ]);
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $response = $this->actingAs($user)->get(route('instituciones.create'));
        $response->assertStatus(403);
    }

    public function test_institucion_cant_create_another_institucion()
    {
        $user = User::factory()
            ->has(Institucion::factory()->count(1), 'instituciones')
            ->create();
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $response = $this->actingAs($user)->get(route('instituciones.create'));
        $response->assertStatus(403);
    }

    public function test_institucion_cant_edit_another_institucion()
    {
        $user = User::factory()
            ->has(Institucion::factory()->count(1), 'instituciones')
            ->create();

        $otroUsuario = User::factory()
            ->has(Institucion::factory()->count(1), 'instituciones')
            ->create();
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $response = $this->actingAs($user)->get(route('instituciones.edit', $otroUsuario->instituciones->id));
        $response->assertStatus(403);

        $response = $this->actingAs($user)->get(route('instituciones.edit', $user->instituciones->id));
        $response->assertStatus(200);
    }

    public function test_institucion_cant_delete_another_institucion()
    {
        $user = User::factory()
            ->has(Institucion::factory()->count(1), 'instituciones')
            ->create();

        $otroUsuario = User::factory()
            ->has(Institucion::factory()->count(1), 'instituciones')
            ->create();
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $response = $this->actingAs($user)->delete(route('instituciones.destroy', $otroUsuario->instituciones->id));
        $response->assertStatus(403);

        $response = $this->actingAs($user)->delete(route('instituciones.destroy', $user->instituciones->id));
        $response->assertRedirect(route('instituciones.create'));
    }
}
