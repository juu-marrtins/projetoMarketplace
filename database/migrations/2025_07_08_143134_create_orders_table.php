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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userId')
                    ->constrained('users', 'id')
                    ->nullOnDelete();
            $table->foreignId('addressId')
                    ->constrained('addresses', 'id');
            $table->dateTime('orderDate');
            $table->foreignId('couponId')
                    ->constrained('coupons', 'id')
                    ->default(null);
            $table->enum('status', ['PENDING', 'PROCESSING', 'SHIPPED', 'COMPLETED', 'CANCELED'])->default('PENDING');
            $table->decimal('totalAmount', 10, 2)->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
