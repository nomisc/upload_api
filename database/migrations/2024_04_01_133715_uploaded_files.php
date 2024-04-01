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
        Schema::create('uploaded_files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('original_name');
            $table->string('file_name');
            $table->string('file_path');
            $table->bigInteger('file_size');
            $table->string('mime_type')->nullable();
            $table->string('extension')->nullable();
            $table->timestamp('uploaded_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('uploaded_files');
    }
};
