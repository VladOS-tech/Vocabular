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
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('moderator_id'); // FK к таблице модераторов
            $table->text('content'); // Содержание уведомления
            $table->boolean('is_read')->default(false); // Статус прочтения (по умолчанию false)
            $table->timestamps();

            // Определение внешнего ключа
            $table->foreign('moderator_id')->references('id')->on('moderators')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
