<?php

use App\Http\Controllers\Cursos\CursoController;
use App\Http\Controllers\Instituciones\BuscadorInstitucionController;
use App\Http\Controllers\Instituciones\InscripcionInstitucionController;
use App\Http\Controllers\Instituciones\InstitucionController;
use App\Http\Controllers\Materias\DocenteMateriaController;
use App\Http\Controllers\Materias\MateriaController;
use App\Http\Controllers\Roles\PermisoController;
use App\Http\Controllers\Roles\RolController;
use App\Http\Controllers\Roles\RolPermisoController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::get('buscador/instituciones', [BuscadorInstitucionController::class, 'mostrarBuscador'])
    ->name('instituciones.mostrarBuscador');
Route::post('buscador/instituciones/filtrar', [BuscadorInstitucionController::class, 'filtrarInstituciones'])
    ->name('instituciones.filtrarInstituciones');

Route::resource('instituciones', InstitucionController::class);
Route::prefix('instituciones/{institucion_id}')->group(function () {
    Route::resource('inscripciones', InscripcionInstitucionController::class)->names('instituciones.inscripciones');
    
    Route::resource('roles', RolController::class);
    Route::resource('permisos', PermisoController::class);
    
    Route::prefix('roles/{rol_id}')->group(function () {
        Route::resource('permisos', RolPermisoController::class)->names('rolPermisos');
    });

    Route::resource('cursos', CursoController::class);
    Route::post('cursos/paginarCursos', [CursoController::class, 'paginarCursos'])
        ->name('cursos.paginarCursos');
    
    Route::prefix('cursos/{curso_id}')->group(function () {
        Route::resource('materias', MateriaController::class);
        
        Route::prefix('materias/{materia_id}')->group(function () {
            Route::resource('docentes', DocenteMateriaController::class)->names('materias.docentes');
            Route::post('roles/docentes', [DocenteMateriaController::class, 'obtenerDocentes'])
                ->name('materias.docentes.obtenerDocentes');
        });
    });
});
