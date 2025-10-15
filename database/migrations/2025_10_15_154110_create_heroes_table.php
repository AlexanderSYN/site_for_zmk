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
        Schema::create('heroes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name_hero')->default('none');
            $table->string('description_hero')->default('none');
            $table->string('type')->default('none');
            $table->string('image_hero')->default('none');
            $table->string('image_qr')->default('none');
            $table->string('added_user_id')
                    ->consntrained('users') // refers to the users table
                    ->onDelete('cascade'); // when a user is deleted, his records are deleted
            $table->string('added_user_name')
                    ->consntrained('users') // refers to the users table
                    ->onDelete('cascade'); // when a user is deleted, his records are deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heroes');
    }
};
