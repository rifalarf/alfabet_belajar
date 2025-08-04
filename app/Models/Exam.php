<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'start_date',
        'end_date',
        'status',
        'time_per_question',
    ];

    /**
     * Sebuah Ulangan (Exam) dimiliki oleh satu User (Guru).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Sebuah Ulangan (Exam) memiliki banyak Hasil Ulangan (ExamResult).
     */
    public function examResults()
    {
        return $this->hasMany(ExamResult::class);
    }

    /**
     * Sebuah Ulangan (Exam) memiliki banyak Soal (Question)
     * melalui tabel perantara exam_questions.
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exam_questions');
    }
}
