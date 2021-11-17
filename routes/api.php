<?php

use App\Http\Controllers\Api\ClaseApiController;
use App\Http\Controllers\Api\CursoApiController;
use App\Http\Controllers\Api\EvaluacionApiController;
use App\Http\Controllers\Api\InstitucionApiController;
use App\Http\Controllers\Api\MateriaApiController;
use App\Http\Controllers\Cursos\CursoController;
use App\Http\Controllers\Instituciones\BuscadorInstitucionController;
use App\Models\Cursos\Curso;
use App\Models\Instituciones\Institucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('instituciones', [InstitucionApiController::class, 'obtenerTodasLasInstituciones']);
Route::get('instituciones/{nombre}', [InstitucionApiController::class, 'buscar']);

Route::prefix('instituciones/{institucion_id}')->group(function () {
    Route::get('cursos', [CursoApiController::class, 'obtenerCursosDeLaInstitucion']);
});

Route::prefix('cursos/{curso_id}')->group(function () {
    Route::get('materias', [MateriaApiController::class, 'obtenerMateriasDelCurso']);
});

Route::prefix('materias/{materia_id}')->group(function () {
    Route::get('evaluaciones', [EvaluacionApiController::class, 'obtenerEvaluacionesDeLaMateria']);

    Route::get('clases', [ClaseApiController::class, 'obtenerClasesDeLaMateria']);
});

Route::get('evaluaciones/{evaluacion_id}', [EvaluacionApiController::class, 'obtenerDetallesDeLaEvaluacion']);

Route::get('clases/{clases_id}', [ClaseApiController::class, 'obtenerDetallesDeLaClase']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
