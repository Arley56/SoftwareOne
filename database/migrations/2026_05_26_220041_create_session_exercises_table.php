<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('session_exercises', function (Blueprint $table) {

            $table->id();

            $table->foreignId('session_enrollment_id')
                ->constrained('session_enrollments')
                ->cascadeOnDelete();

            $table->foreignId('uploaded_by_user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('original_name');

            $table->string('file_path');

            $table->string('mime_type')->nullable();

            $table->unsignedBigInteger('size')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('session_exercises');
    }
};