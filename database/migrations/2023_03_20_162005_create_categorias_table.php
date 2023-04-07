<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nome');
            $table->string('descricao');
            $table->string('operacao')->default('saida');
            $table->integer('parent_id')->nullable();
            $table->timestamps();
        });
        Schema::table('categorias', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('categorias')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
