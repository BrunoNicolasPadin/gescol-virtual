<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntregasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entregas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('evaluacion_id')->index()->constrained('evaluaciones')->onDelete('cascade');
            $table->foreignUuid('alumno_materia_id')->index()->constrained('alumnos_materias')->onDelete('cascade');
            $table->string('calificacion')->nullable();
            $table->text('comentario')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entregas');
    }
}
