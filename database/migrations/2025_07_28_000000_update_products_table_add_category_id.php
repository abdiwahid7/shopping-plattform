<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductsTableAddCategoryId extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the old 'category' string column
            $table->dropColumn('category');

            // Add 'category_id' foreign key column
            $table->foreignId('category_id')->after('description')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the foreign key and column
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');

            // Add back the 'category' string column
            $table->string('category')->after('description');
        });
    }
}
