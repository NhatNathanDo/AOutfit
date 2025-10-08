<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('outfit_set_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('outfit_set_id');
            $table->uuid('product_id');
            $table->foreign('outfit_set_id')->references('id')->on('outfit_sets')->cascadeOnDelete();
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('outfit_set_items');
    }
};
