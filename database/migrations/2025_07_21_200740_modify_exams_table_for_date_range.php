<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropColumn('code'); 
            $table->dropColumn('due_date');
            $table->date('start_date')->after('status'); 
            $table->date('end_date')->after('start_date'); 
        });
    }

    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->string('code', 8)->unique()->after('title');
            $table->date('due_date')->after('status');
            $table->dropColumn(['start_date', 'end_date']);
        });
    }
};
