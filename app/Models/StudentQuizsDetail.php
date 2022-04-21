<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentQuizsDetail extends Model
{
    use HasFactory;
    protected $table = "student_quiz_detail";
    public $fillable = [
        'student_quiz_id',
        'answer_id'
    ];

    public $timestamps = false;
    public function answers()
    {
        return $this->belongsTo(Answer::class, 'answer_id')->with('questions');
    }

    public function studentQuiz()
    {
        return $this->belongsTo(StudentQuiz::class, 'student_quiz_id')->with('teams');
    }
}