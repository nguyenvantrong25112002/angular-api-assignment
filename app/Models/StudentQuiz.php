<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentQuiz extends Model
{
    use HasFactory;
    protected $table = "student_quizs";
    protected $primaryKey = "id";

    public $fillable = [
        'student_id',
        'quiz_id',
        'score',
    ];
    public function studentQuizDetail()
    {
        return $this->hasMany(StudentQuizsDetail::class, 'student_quiz_id')->with('answers');
    }
    public function quizs()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id')->with('subjects');
    }

    public function students()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}