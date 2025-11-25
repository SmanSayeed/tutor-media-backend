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
        Schema::create('zone_areas', function (Blueprint $table) {
            // Primary key, auto-increment
            $table->id();

            // Division name, required string field
            $table->string('division_name', 255);

            // Zone name (represents district name), required string field
            $table->string('zone_name', 255);

            // Shipping charge, nullable decimal (8 digits total, 2 after decimal)
            // Null means use default from config
            $table->decimal('shipping_charge', 8, 2)->nullable();

            // Status enum with default value 'active'
            $table->enum('status', ['active', 'deactive'])->default('active');

            // Timestamps for created_at and updated_at
            $table->timestamps();

            // Unique constraint on division_name and zone_name combination
            $table->unique(['division_name', 'zone_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zone_areas');
    }
};
