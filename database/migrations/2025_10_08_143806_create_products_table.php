<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 150);
            $table->string('slug', 200);
            $table->uuid('category_id');
            $table->uuid('brand_id');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->enum('gender', ['male', 'female', 'unisex']);
            $table->string('style', 50)->nullable();
            $table->string('color', 50)->nullable();
            $table->string('material', 100)->nullable();
            $table->text('image_url')->nullable();
            $table->integer('stock')->default(0);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
            $table->foreign('brand_id')->references('id')->on('brands')->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('products');
    }
};
