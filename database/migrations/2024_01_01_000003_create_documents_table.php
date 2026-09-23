<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('document_number')->nullable();
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict');
            $table->string('department')->nullable();
            $table->string('academic_year')->nullable();
            $table->string('semester')->nullable();
            $table->string('course_name')->nullable();
            $table->string('pic')->nullable();
            $table->text('description')->nullable();
            $table->json('tags')->nullable();
            $table->date('document_date');
            $table->date('upload_date');
            $table->timestamp('original_uploaded_at');
            $table->string('status')->default('draft'); // draft, submitted, review, revision, approved, archived
            $table->integer('current_version')->default(1);
            $table->foreignId('created_by')->constrained('users')->onDelete('restrict');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('academic_year');
            $table->index('semester');
            $table->index('document_date');
            $table->index('upload_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
