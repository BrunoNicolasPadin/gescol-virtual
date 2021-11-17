<?php

use App\Http\Controllers\Archivos\ArchivoController;
use App\Http\Controllers\Auth\ResetearContrasenaController;
use App\Http\Controllers\Auth\VerificacionEmailController;
use App\Http\Controllers\Clases\ClaseController;
use App\Http\Controllers\Comentarios\ComentarioController;
use App\Http\Controllers\Comentarios\RespuestaController;
use App\Http\Controllers\Correcciones\CorreccionController;
use App\Http\Controllers\Cursos\CursoController;
use App\Http\Controllers\Entregas\EntregaController;
use App\Http\Controllers\Evaluaciones\EvaluacionController;
use App\Http\Controllers\Instituciones\BuscadorInstitucionController;
use App\Http\Controllers\Instituciones\InscripcionInstitucionController;
use App\Http\Controllers\Instituciones\InstitucionController;
use App\Http\Controllers\Materias\AlumnoMateriaController;
use App\Http\Controllers\Materias\DocenteMateriaController;
use App\Http\Controllers\Materias\MateriaController;
use App\Http\Controllers\Notificaciones\NotificacionController;
use App\Http\Controllers\Paneles\PanelController;
use App\Http\Controllers\Paneles\PanelRolController;
use App\Http\Controllers\Roles\RolController;
use App\Http\Controllers\Roles\RolPermisoController;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
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
    $check = Auth::check();
    return Inertia::render('Welcome', [
        'canLogin' => $check = ($check === true) ? false : true,
        'canRegister' => Route::has('register'),
        /* 'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION, */
    ]);
})->name('inicio');

//VERIFICAR EMAIL AL REGISTRARSE

Route::get('email/verify', [VerificacionEmailController::class, 'avisarVerificacion'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('email/verify/{id}/{hash}', [VerificacionEmailController::class, 'verificar'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('email/verification-notification', [VerificacionEmailController::class, 'enviarVerificacion'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

// RESETEAR CONTRASENA

Route::get('forgot-password', [ResetearContrasenaController::class, 'olvidoContrasena'])
    ->middleware('guest')
    ->name('password.request');

Route::post('forgot-password', [ResetearContrasenaController::class, 'enviarEmail'])
    ->middleware('guest')
    ->name('password.email');

Route::get('reset-password/{token}', [ResetearContrasenaController::class, 'resetear'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('reset-password', [ResetearContrasenaController::class, 'actualizarContrasena'])
    ->middleware('guest')
    ->name('password.update');

/* Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard'); */

Route::middleware([Authenticate::class])->group(function () {

    Route::get('buscador/instituciones', [BuscadorInstitucionController::class, 'mostrarBuscador'])
        ->name('instituciones.mostrarBuscador');
    Route::post('buscador/instituciones/filtrar', [BuscadorInstitucionController::class, 'filtrarInstituciones'])
        ->name('instituciones.filtrarInstituciones');

    Route::resource('instituciones', InstitucionController::class)->except(['index', 'show']);
    Route::prefix('instituciones/{institucion_id}')->group(function () {
        Route::resource('inscripciones', InscripcionInstitucionController::class)
            ->except(['index', 'show'])
            ->names('instituciones.inscripciones');
        
        Route::resource('roles', RolController::class)->except(['index', 'show']);
        
        Route::prefix('roles/{rol_id}')->group(function () {
            Route::resource('permisos', RolPermisoController::class)->names('rolPermisos');
        });

        Route::resource('cursos', CursoController::class)->except(['show']);
        Route::post('cursos/paginarCursos', [CursoController::class, 'paginarCursos'])
            ->name('cursos.paginarCursos');
        
        Route::prefix('cursos/{curso_id}')->group(function () {
            Route::resource('materias', MateriaController::class)->except(['show']);
            
            Route::prefix('materias/{materia_id}')->group(function () {
                Route::resource('docentes', DocenteMateriaController::class)->names('materias.docentes');
                Route::post('roles/docentes', [DocenteMateriaController::class, 'obtenerDocentes'])
                    ->name('materias.docentes.obtenerDocentes');
                
                Route::resource('alumnos', AlumnoMateriaController::class)->names('materias.alumnos');

                Route::resource('evaluaciones', EvaluacionController::class);
                Route::post('evaluaciones/paginarEvaluaciones', [EvaluacionController::class, 'paginarEvaluaciones'])
                    ->name('evaluaciones.paginarEvaluaciones');
                
                Route::prefix('evaluaciones/{evaluacion_id}')->group(function () {
                    Route::resource('entregas', EntregaController::class);

                    Route::post('paginarComentarios', [EvaluacionController::class, 'paginarComentarios'])
                        ->name('evaluaciones.paginarComentarios');

                    Route::prefix('entregas/{entrega_id}')->group(function () {
                        Route::resource('correcciones', CorreccionController::class);
                        Route::post('paginarComentarios', [EntregaController::class, 'paginarComentarios'])
                            ->name('entregas.paginarComentarios');
                    });
                });

                Route::resource('clases', ClaseController::class);
                Route::post('clases/paginarClases', [ClaseController::class, 'paginarClases'])
                    ->name('clases.paginarClases');
                Route::prefix('clases/{clase_id}')->group(function () {
                    Route::post('paginarComentarios', [ClaseController::class, 'paginarComentarios'])
                        ->name('clases.paginarComentarios');
                });
            });
        });
    });
    //Archivos y comentarios
    Route::resource('archivos', ArchivoController::class);

    Route::resource('comentarios', ComentarioController::class);
    Route::prefix('comentarios/{comentario_id}')->group(function () {
        Route::resource('respuestas', RespuestaController::class);
        Route::post('respuestas/paginarRespuestas', [RespuestaController::class, 'paginarRespuestas'])
            ->name('respuestas.paginarRespuestas');
    });

    //Panel
    Route::prefix('panel')->group(function () {
        Route::get('', [PanelController::class, 'mostrarInicio'])->name('panel.mostrarInicio');
        Route::prefix('instituciones/{institucion_id}')->group(function () {
            Route::get('roles', [PanelRolController::class, 'mostrarRoles'])->name('panel.mostrarRoles');
        });
    });

    //Notificaciones
    Route::get('notificaciones', [NotificacionController::class, 'listar'])->name('notificaciones.listar');
    Route::get('notificaciones/contar', [NotificacionController::class, 'contarNotificacionesSinLeer'])
        ->name('notificaciones.contarNotificacionesSinLeer');
    Route::get('notificaciones/{notificacion_id}/marcar-como-leida', [NotificacionController::class, 'marcarComoLeida'])
        ->name('notificaciones.marcarComoLeida');
    Route::get('notificaciones/marcar-todas-como-leidas', [NotificacionController::class, 'marcarTodasComoLeidas'])
        ->name('notificaciones.marcarTodasComoLeidas');
});
