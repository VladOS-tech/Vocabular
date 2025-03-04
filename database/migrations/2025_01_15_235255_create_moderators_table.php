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
        Schema::create('moderators', function (Blueprint $table) {
        $table->id();  // Убедитесь, что это поле primary key для таблицы 'moderators'
        $table->unsignedBigInteger('user_id');  // Внешний ключ на 'id' из таблицы 'users'
        $table->string('contact')->unique();
        $table->boolean('online_status')->default(false);
        $table->timestamps();

        // Внешний ключ на 'id' из таблицы 'users'
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moderators');
    }
};
