<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('materia_id')->index()->constrained('materias')->onDelete('cascade');
            $table->string('nombre');
            $table->text('descripcion');
            $table->dateTime('fechaHoraComienzo');
            $table->dateTime('fechaHoraFinalizacion');
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
        Schema::dropIfExists('evaluaciones');
    }
}
