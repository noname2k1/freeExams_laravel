<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('exams', function (Blueprint $table) {
            $table->id('exam_id');
            $table->string('exam_name');
            $table->text('exam_description');
            $table->string('exam_type');
            $table->integer('exam_duration');
            $table->string('exam_status')->default('draft')->in_array(['draft', 'published']);
            $table->foreignId('created_by')->constrained('users', 'user_id', 'exams_user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('exams');

    }
};