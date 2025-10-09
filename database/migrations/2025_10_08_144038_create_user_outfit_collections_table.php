<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_outfit_collections', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('outfit_set_id');
            $table->text('note')->nullable();
            $table->boolean('is_favorite')->default(false);
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('outfit_set_id')->references('id')->on('outfit_sets')->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('user_outfit_collections');
    }
};
