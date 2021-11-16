<?php

namespace App\Providers;

use App\Models\Archivos\Archivo;
use App\Models\Clases\Clase;
use App\Models\Comentarios\Comentario;
use App\Models\Comentarios\Respuesta;
use App\Models\Correcciones\Correccion;
use App\Models\Cursos\Curso;
use App\Models\Entregas\Entrega;
use App\Models\Evaluaciones\Evaluacion;
use App\Models\Instituciones\Institucion;
use App\Models\Materias\AlumnoMateria;
use App\Models\Materias\DocenteMateria;
use App\Models\Materias\Materia;
use App\Models\Roles\PermisoRol;
use App\Models\Roles\Rol;
use App\Models\Roles\RolUser;
use App\Policies\Archivos\ArchivoPolicy;
use App\Policies\Clases\ClasePolicy;
use App\Policies\Comentarios\ComentarioPolicy;
use App\Policies\Comentarios\RespuestaPolicy;
use App\Policies\Correcciones\CorreccionPolicy;
use App\Policies\Cursos\CursoPolicy;
use App\Policies\Entregas\EntregaPolicy;
use App\Policies\Evaluaciones\EvaluacionPolicy;
use App\Policies\Instituciones\InscripcionPolicy;
use App\Policies\Instituciones\institucionPolicy;
use App\Policies\Materias\AlumnoPolicy;
use App\Policies\Materias\DocentePolicy;
use App\Policies\Materias\MateriaPolicy;
use App\Policies\Roles\RolPermisoPolicy;
use App\Policies\Roles\RolPolicy;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        AlumnoMateria::class => AlumnoPolicy::class,
        Archivo::class => ArchivoPolicy::class,
        Clase::class => ClasePolicy::class,
        Comentario::class => ComentarioPolicy::class,
        Correccion::class => CorreccionPolicy::class,
        Curso::class => CursoPolicy::class,
        DocenteMateria::class => DocentePolicy::class,
        Entrega::class => EntregaPolicy::class,
        Evaluacion::class => EvaluacionPolicy::class,
        Institucion::class => institucionPolicy::class,
        Materia::class => MateriaPolicy::class,
        PermisoRol::class => RolPermisoPolicy::class,
        Respuesta::class => RespuestaPolicy::class,
        Rol::class => RolPolicy::class,
        RolUser::class => InscripcionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('Verificar email')
                ->line('Haz click en el boton de abajo para verificar tu email.')
                ->action('Verificar email', $url);
        });
    }
}
