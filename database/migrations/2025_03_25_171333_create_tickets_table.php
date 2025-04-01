<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->string('asunto');       
            $table->string('tipo');         
            $table->text('descripcion');    
            $table->enum('estado', ['esperando', 'abierto', 'en_progreso', 'cerrado'])->default('esperando');
            $table->enum('prioridad', ['baja', 'media', 'alta'])->default('media');
            $table->json('archivos')->nullable();
            $table->text('comentario')->nullable();
            $table->unsignedBigInteger('encargado_id')->nullable();
            $table->timestamps();
    
            // Define la clave foránea
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
