<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = "questions";
    protected $primaryKey = "id";
    public $fillable = [
        'text',
        'quiz_id',
    ];
    // protected $guarded = [];
    // public $timestamps = true;
    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id');
    }
}