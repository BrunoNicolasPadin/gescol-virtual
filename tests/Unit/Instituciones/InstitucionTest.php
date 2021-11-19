<?php

namespace Tests\Unit\Instituciones;

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
        $institucion = Institucion::factory()->create();
        $institucion->with('user')->first();

        $response = $this->actingAs($institucion->user)->get(route('instituciones.create'));
        $response->assertStatus(403);
    }

    public function test_institucion_cant_edit_another_institucion()
    {
        $institucion = Institucion::factory()->create();
        $institucion->with('user')->first();

        $otraInstitucion = Institucion::factory()->create();
        $otraInstitucion->with('user')->first();
    
        $response = $this->actingAs($institucion->user)->get(route('instituciones.edit', $institucion->id));
        $response->assertStatus(200);

        $response = $this->actingAs($otraInstitucion->user)->get(route('instituciones.edit', $institucion->id));
        $response->assertStatus(403);
    }

    public function test_institucion_cant_delete_another_institucion()
    {
        $institucion = Institucion::factory()->create();
        $institucion->with('user')->first();

        $otraInstitucion = Institucion::factory()->create();
        $otraInstitucion->with('user')->first();

        $institucionNoEliminable = Institucion::factory()->create();
        $institucionNoEliminable->with('user')->first();

        $response = $this->actingAs($institucion->user)->delete(route('instituciones.destroy', $institucion->id));
        $response->assertRedirect(route('instituciones.create'));

        $response = $this->actingAs($otraInstitucion->user)->delete(route('instituciones.destroy', $institucionNoEliminable->id));
        $response->assertStatus(403);
    }
}
