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

        Schema::create('complements', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('name', 100);
            $table->decimal('price', 10, 2);
            $table->string('image_url', 255)->nullable();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete()->unsigned();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complements');
    }
};
