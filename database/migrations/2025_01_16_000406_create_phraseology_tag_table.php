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
        Schema::create('phraseology_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('phraseology_id'); // FK к таблице фразеологизмов
            $table->unsignedBigInteger('tag_id'); // FK к таблице тегов
            $table->timestamps();

            // Определение внешних ключей
            $table->foreign('phraseology_id')->references('id')->on('phraseologies')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');

            // Уникальное составное ограничение
            $table->unique(['phraseology_id', 'tag_id'], 'phraseology_tag_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phraseology_tag');
    }
};

