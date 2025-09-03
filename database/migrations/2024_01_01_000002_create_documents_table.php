<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create documents table for file management
 * Handles file uploads, metadata, and access control
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_name'); // Stored file name
            $table->string('original_name'); // Original uploaded file name
            $table->string('file_path'); // Path to file in storage
            $table->bigInteger('file_size'); // File size in bytes
            $table->string('file_type'); // MIME type
            $table->string('category')->nullable();
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->integer('download_count')->default(0);
            $table->boolean('is_public')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index('category');
            $table->index('uploaded_by');
            $table->index(['is_public', 'created_at']);
            // Note: SQLite doesn't support fulltext indexes, so we'll skip that for now
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
