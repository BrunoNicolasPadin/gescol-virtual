<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlumnosMateriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnos_materias', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('rol_user_id')->index()->constrained('roles_users')->onDelete('cascade');
            $table->foreignUuid('materia_id')->index()->constrained('materias')->onDelete('cascade');
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
        Schema::dropIfExists('alumnos_materias');
    }
}
