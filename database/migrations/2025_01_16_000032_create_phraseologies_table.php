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
        Schema::create('phraseologies', function (Blueprint $table) {
            $table->id('id'); // Основной ключ - ID фразеологизма
            $table->string('content')->unique(); // Уникальность содержимого
            $table->text('meaning'); // Значение фразеологизма
            $table->enum('status', ['approved', 'pending'])->default('pending'); // Статус (одобрен или отправлен на одобрение)
            $table->timestamps(); // Поля created_at и updated_at
            $table->dateTime('confirmed_at')->nullable(); // Дата подтверждения (если фразеологизм одобрен)
            $table->unsignedBigInteger('moderator_id')->nullable(); // FK к таблице Модераторы
            $table->foreign('moderator_id')->references('id')->on('moderators')->onDelete('set null');
            // Добавляем внешний ключ для связи с таблицей Модераторов
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phraseologies');
    }
};
