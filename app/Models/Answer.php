<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $table = "answers";
    protected $primaryKey = "id";
    public $fillable = [
        'text',
        'question_id',
        'is_correct',
    ];
    public function questions()
    {
        return $this->belongsTo(Question::class, 'question_id')->with('answers');
    }
}