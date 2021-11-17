<?php

namespace App\Http\Controllers\Instituciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Instituciones\StoreInstitucionRequest;
use App\Http\Requests\Instituciones\UpdateInstitucionRequest;
use App\Models\Instituciones\Institucion;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class InstitucionController extends Controller
{
    public function create()
    {
        $this->authorize('create', Institucion::class);
        return Inertia::render('Instituciones/Create');
    }

    public function store(StoreInstitucionRequest $request)
    {
        $this->authorize('create', Institucion::class);
        $institucion = new Institucion();
        $institucion->nombre = $request->nombre;
        $institucion->user()->associate(Auth::id());
        $institucion->save();

        return redirect()->route('cursos.index', $institucion->id)
            ->with('message', 'Institución creada. Ahora agregar tus cursos');
    }

    public function edit(Institucion $institucione)
    {
        $this->authorize('update', $institucione);

        return Inertia::render('Instituciones/Edit', [
            'institucion' => $institucione,
        ]);
    }

    public function update(
        UpdateInstitucionRequest $request,
        Institucion $institucione
    ) {
        $this->authorize('update', $institucione);

        $institucione->nombre = $request->nombre;
        $institucione->save();

        return redirect()->route('cursos.index', $institucione->id)
            ->with('message', 'Institución actualizada');
    }

    public function destroy(Institucion $institucione)
    {
        $this->authorize('delete', $institucione);

        $institucione->delete();

        return redirect()->route('instituciones.create')
            ->with('message', 'Institución eliminada');
    }
}
