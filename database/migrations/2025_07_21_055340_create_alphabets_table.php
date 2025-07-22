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
        Schema::create('alphabets', function (Blueprint $table) {
            $table->id(); 
            $table->string('letter', 1)->unique(); // Kangge huruf (A, B, C), kedah unik
            $table->string('image_path'); // Kangge path gambar alfabet
            $table->string('video_path'); // Kangge path video gerak bibir
            $table->string('sound_path'); // Kangge path suara pelafalan
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alphabets');
    }
};
