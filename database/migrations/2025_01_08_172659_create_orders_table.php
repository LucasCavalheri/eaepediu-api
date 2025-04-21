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
        Schema::disableForeignKeyConstraints();

        Schema::create('orders', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->enum('status', ['PENDING', 'CANCELED', 'DELIVERING', 'DELIVERED'])->default('PENDING');
            $table->decimal('total_price', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->unsignedInteger('preparation_time')->nullable();
            $table->unsignedInteger('delivery_time')->nullable();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete()->unsigned();
            $table->foreignId('restaurant_id')->constrained()->cascadeOnDelete()->unsigned();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
