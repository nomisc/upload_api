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
        //
        Schema::table('uploaded_files', function (Blueprint $table) {
            // Add the new fields
            $table->string('description')->nullable();
            $table->integer('title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('existing_table_name', function (Blueprint $table) {
            // Drop the new fields if migration is rolled back
            $table->dropColumn('description');
            $table->dropColumn('title');
        });
    }
};
