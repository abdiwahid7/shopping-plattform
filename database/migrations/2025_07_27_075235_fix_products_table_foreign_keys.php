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
        Schema::table('products', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['category_id']);

            // Drop the category_id column
            $table->dropColumn('category_id');

            // Ensure category column exists
            if (!Schema::hasColumn('products', 'category')) {
                $table->string('category')->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop category column if it exists
            if (Schema::hasColumn('products', 'category')) {
                $table->dropColumn('category');
            }

            // Add back category_id column
            $table->unsignedBigInteger('category_id')->nullable();

            // Add back foreign key constraint (if you have a categories table)
            // $table->foreign('category_id')->references('id')->on('categories');
        });
    }
};
