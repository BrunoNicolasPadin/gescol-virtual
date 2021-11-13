<?php

namespace App\Http\Controllers\Materias;

use App\Http\Controllers\Controller;
use App\Models\Materias\AlumnoMateria;
use App\Models\Roles\RolUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlumnoMateriaController extends Controller
{
    public function index($institucion_id, $curso_id, $materia_id)
    {
        //
    }

    public function store(Request $request, $institucion_id, $curso_id, $materia_id)
    {
        $rolUser = RolUser::where('user_id', Auth::id())->first();
        $alumnoMateria = new AlumnoMateria();
        $alumnoMateria->rolUser()->associate($rolUser->id);
        $alumnoMateria->materia()->associate($materia_id);
        $alumnoMateria->save();

        return redirect()->back()->with('message', 'Te anotaste correctamente');
    }

    public function destroy($institucion_id, $curso_id, $materia_id, $id)
    {
        AlumnoMateria::destroy($id);
        return redirect()->back()->with('message', 'Te DESANOTASTE correctamente');
    }
}
