<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('questions', function (Blueprint $table) {
            $table->id('question_id');
            $table->string('question_text');
            $table->text('options');
            $table->string('answer');
            $table->foreignId('exam_id')->constrained('exams', 'exam_id', 'questions_exam_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('questions');
    }
};