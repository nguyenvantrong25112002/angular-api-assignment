<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    protected $table = "quizs";
    protected $primaryKey = "id";
    public $fillable = [
        'name',
        'subject_id',
        'duration_minutes',
        'start_time',
        'end_time',
        'status',
        'is_shuffle'
    ];
    public function questions()
    {
        return $this->hasMany(Question::class, 'quiz_id');
    }
    // protected $guarded = [];
    // public $timestamps = true;
    public function subjects()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}