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

        Schema::create('restaurants', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('subdomain', 100)->unique();
            $table->string('name', 255);
            $table->string('phone_number')->nullable();
            $table->json('address');
            $table->json('colors')->nullable();
            $table->json('opening_hours')->nullable();
            $table->string('image_url', 255)->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->unsigned();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
