<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('identificacion', 20);
            $table->string('name', 50);
            $table->string('email', 100)->unique();
            $table->string('username', 20);
            $table->string('password', 100);
            $table->string('telefono', 30)->nullable();
            $table->text('direccion', 255)->nullable();
            $table->integer('curso')->unsigned();
            $table->string('estado', 20);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
