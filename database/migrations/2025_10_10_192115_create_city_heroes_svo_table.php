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
        Schema::create('heroes_svo', function (Blueprint $table) {
            $table->id()->primary();
            $table->timestamps();

            $table->string('city');
            $table->string('added_user_id')
                ->consntrained('users') // refers to the users table
                ->onDelete('cascade'); // when a user is deleted, his records are deleted
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heroes_svo');
    }
};
