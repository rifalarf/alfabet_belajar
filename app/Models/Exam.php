<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    /**
     * Sebuah Ulangan (Exam) memiliki banyak Soal (Question)
     * melalui tabel perantara exam_questions.
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exam_questions');
    }
}
