<?php

namespace App\Http\Controllers\Instituciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Instituciones\StoreInstitucionRequest;
use App\Http\Requests\Instituciones\UpdateInstitucionRequest;
use App\Models\Instituciones\Institucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class InstitucionController extends Controller
{
    public function index()
    {
        echo 'Instituciones - Index';
    }

    public function create()
    {
        return Inertia::render('Instituciones/Create');
    }

    public function store(StoreInstitucionRequest $request)
    {
        $institucion = new Institucion();
        $institucion->nombre = $request->nombre;
        $institucion->claveDeAcceso = Hash::make($request->claveDeAccesoNueva);
        $institucion->user()->associate(Auth::id());
        $institucion->save();

        //Llevar a los cursos
        return redirect(route('instituciones.index'));
    }

    public function show($id)
    {
        echo 'Instituciones - Show';
    }

    public function edit($id)
    {
        return Inertia::render('Instituciones/Edit', [
            'institucion' => Institucion::findOrFail($id),
        ]);
    }

    public function update(UpdateInstitucionRequest $request, $id)
    {
        $institucion = Institucion::findOrFail($id);
        if (! $request->claveDeAccesoActual == null) {
            if (Hash::check($request->claveDeAccesoActual, $institucion->claveDeAcceso)) {
                $institucion->claveDeAcceso = Hash::make($request->claveDeAccesoNueva);
            }
            //Avisar que la clave de acceso no coincide
        }

        $institucion->nombre = $request->nombre;
        $institucion->save();

        //Llevarlo a su perfil
        return redirect(route('instituciones.index'));
    }

    public function destroy($id)
    {
        echo 'Instituciones - Destroy';
    }
}
