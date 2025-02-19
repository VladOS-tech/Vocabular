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
        Schema::create('users', function (Blueprint $table) {
        $table->id('id');  // Используйте 'id' для первичного ключа
        $table->string('name')->unique();
        $table->string('password');
        $table->unsignedBigInteger('role_id');  // Внешний ключ для связи с таблицей ролей
        $table->timestamps();

        $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.s
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
