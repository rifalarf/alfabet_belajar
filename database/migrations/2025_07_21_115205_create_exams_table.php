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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->comment('Guru yang membuat ulangan')->constrained()->onDelete('cascade');
            $table->string('title'); 
            $table->string('code', 8)->unique(); 
            $table->integer('time_per_question')->default(60); // Waktu per soal dalam detik
            $table->enum('status', ['pending', 'active', 'finished'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
