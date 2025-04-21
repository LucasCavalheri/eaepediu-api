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

        Schema::create('order_items', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete()->unsigned();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete()->unsigned();
            $table->foreignId('complement_id')->nullable()->constrained()->cascadeOnDelete()->unsigned();
            $table->unsignedInteger('quantity');
            $table->decimal('subtotal', 10, 2)->default(0); // Valor total (quantidade × preço)
            $table->decimal('price', 10, 2)->default(0);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
