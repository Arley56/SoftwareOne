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
        Schema::table('session_enrollments', function (Blueprint $table) {

            $table->string('student_file')->nullable();

            $table->string('student_file_mime')->nullable();

            $table->unsignedBigInteger('student_file_size')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('session_enrollments', function (Blueprint $table) {
            //
        });
    }
};
