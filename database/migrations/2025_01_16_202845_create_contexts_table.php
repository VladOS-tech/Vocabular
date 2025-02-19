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
        Schema::create('contexts', function (Blueprint $table) {
            $table->id('id'); // Основной ключ - ID контекста
            $table->unsignedBigInteger('phraseology_id'); // FK к таблице фразеологизмов
            $table->text('content'); // Текст контекста
            $table->timestamps(); // Поля created_at и updated_at

            // Внешний ключ с каскадным удалением
            $table->foreign('phraseology_id')->references('id')->on('phraseologies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contexts');
    }
};

