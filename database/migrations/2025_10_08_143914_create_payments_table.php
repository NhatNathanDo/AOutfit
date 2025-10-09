<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('order_id');
            $table->string('transaction_id', 150);
            $table->string('payment_gateway', 100);
            $table->decimal('amount', 10, 2);
            $table->string('currency', 10)->default('VND');
            $table->enum('status', ['initiated', 'success', 'failed', 'refunded'])->default('initiated');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('payments');
    }
};
