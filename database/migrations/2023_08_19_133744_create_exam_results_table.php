<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id('result_id');
            $table->float('score');
            $table->foreignId('user_id')->constrained('users', 'user_id', 'results_user_id')->onDelete('cascade');
            $table->foreignId('exam_id')->constrained('exams', 'exam_id', 'results_exam_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('exam_results');
    }
};
