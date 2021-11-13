<?php

namespace App\Http\Controllers\Materias;

use App\Http\Controllers\Controller;
use App\Http\Requests\Materias\StoreDocenteMateriaRequest;
use App\Models\Cursos\Curso;
use App\Models\Instituciones\Institucion;
use App\Models\Materias\DocenteMateria;
use App\Models\Materias\Materia;
use App\Models\Roles\Rol;
use App\Models\Roles\RolUser;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class DocenteMateriaController extends Controller
{
    public function index($institucion_id, $curso_id, $materia_id)
    {
        $this->authorize('viewAny', DocenteMateria::class);

        return Inertia::render('Materias/Docentes/Index', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')
                ->findOrFail($curso_id),
            'materia' => Materia::findOrFail($materia_id),
            'docentes' => DocenteMateria::where('materia_id', $materia_id)
                ->with('rolUser.user')
                ->get(),
        ]);
    }

    public function create($institucion_id, $curso_id, $materia_id)
    {
        $this->authorize('create', DocenteMateria::class);

        return Inertia::render('Materias/Docentes/Create', [
            'institucion' => Institucion::select('id', 'nombre')
                ->findOrFail($institucion_id),
            'curso' => Curso::select('id', 'nombre')
                ->findOrFail($curso_id),
            'materia' => Materia::findOrFail($materia_id),
            'roles' => Rol::where('institucion_id', $institucion_id)
                ->orderBy('nombre')
                ->get(),
        ]);
    }

    public function obtenerDocentes(Request $request, $institucion_id, $curso_id, $materia_id)
    {
        return RolUser::where('rol_id', $request->rol_id)->with('user:id,name')->get();
    }

    public function store(StoreDocenteMateriaRequest $request, $institucion_id, $curso_id, $materia_id)
    {
        $this->authorize('create', DocenteMateria::class);

        for ($i = 0; $i < count($request->docentesMateria); $i++) { 
            $docenteMateria = new DocenteMateria();
            $docenteMateria->rolUser()->associate($request->docentesMateria[$i]['docente_id']);
            $docenteMateria->materia()->associate($materia_id);
            $docenteMateria->save();
        }

        return redirect(route('materias.docentes.index', [$institucion_id, $curso_id, $materia_id]))
            ->with('message', 'Docente/s agregado/s');
    }

    public function destroy($institucion_id, $curso_id, $materia_id, DocenteMateria $docente)
    {
        $this->authorize('delete', $docente);

        $docente->delete();

        return redirect(route('materias.docentes.index', [$institucion_id, $curso_id, $materia_id]))
            ->with('message', 'Docente eliminado');
    }
}
