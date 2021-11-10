<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorreccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correcciones', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('entrega_id')->index()->constrained('entregas')->onDelete('cascade');
            $table->binary('archivo');
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
        Schema::dropIfExists('correcciones');
    }
}
