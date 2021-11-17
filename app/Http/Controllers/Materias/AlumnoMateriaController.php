<?php

namespace App\Http\Controllers\Materias;

use App\Http\Controllers\Controller;
use App\Models\Materias\AlumnoMateria;
use App\Models\Roles\RolUser;
use Illuminate\Support\Facades\Auth;

class AlumnoMateriaController extends Controller
{
    public function store(
        $institucion_id,
        $curso_id,
        $materia_id
    ) {
        $this->authorize('create', AlumnoMateria::class);

        $rolUser = RolUser::where('user_id', Auth::id())->first();
        $alumnoMateria = new AlumnoMateria();
        $alumnoMateria->rolUser()->associate($rolUser->id);
        $alumnoMateria->materia()->associate($materia_id);
        $alumnoMateria->save();

        return redirect(route('materias.index', [$institucion_id, $curso_id]))
            ->with('message', 'Te anotaste correctamente');
    }

    public function destroy(
        $institucion_id,
        $curso_id,
        $materia_id,
        AlumnoMateria $alumno
    ) {
        $this->authorize('delete', $alumno);
        $alumno->delete();

        return redirect(route('materias.index', [$institucion_id, $curso_id]))
            ->with('message', 'Te desanotaste correctamente');
    }
}
