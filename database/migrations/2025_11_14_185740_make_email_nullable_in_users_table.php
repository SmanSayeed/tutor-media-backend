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
        Schema::table('users', function (Blueprint $table) {
            // Drop the unique index first
            $table->dropUnique(['email']);
        });
        
        // Modify the column to be nullable
        \DB::statement('ALTER TABLE `users` MODIFY `email` VARCHAR(255) NULL');
        
        Schema::table('users', function (Blueprint $table) {
            // Re-add the unique index (MySQL allows multiple NULL values in unique columns)
            $table->unique('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First, update any NULL emails to a unique placeholder
        \DB::table('users')
            ->whereNull('email')
            ->update(['email' => \DB::raw("CONCAT('user_', id, '@placeholder.com')")]);
        
        Schema::table('users', function (Blueprint $table) {
            // Drop the unique index
            $table->dropUnique(['email']);
        });
        
        // Modify the column to be non-nullable
        \DB::statement('ALTER TABLE `users` MODIFY `email` VARCHAR(255) NOT NULL');
        
        Schema::table('users', function (Blueprint $table) {
            // Re-add the unique index
            $table->unique('email');
        });
    }
};
