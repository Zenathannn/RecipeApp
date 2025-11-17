<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // database/migrations/xxxx_create_recipes_table.php
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id('id_recipe');
            $table->string('username');
            $table->string('category');
            $table->string('title');
            $table->text('description');
            $table->string('image_url')->nullable(); // Tetap ada untuk URL
            $table->string('image_path')->nullable(); // Tambah untuk upload file
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
