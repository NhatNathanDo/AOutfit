<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('outfit_sets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 150);
            $table->text('description')->nullable();
            $table->string('style', 50)->nullable();
            $table->enum('gender', ['male', 'female', 'unisex']);
            $table->text('image_preview')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('outfit_sets');
    }
};

