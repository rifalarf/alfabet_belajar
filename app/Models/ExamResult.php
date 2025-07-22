<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'exam_id',
        'student_name',
        'score',
        'face_image_path',
        'correct_answers', 
        'total_questions',
    ];

    /**
     * Sebuah Hasil Ulangan (ExamResult) dimiliki oleh satu Ulangan (Exam).
     */
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
