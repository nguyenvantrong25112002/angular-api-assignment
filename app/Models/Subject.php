<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;
    protected $table = "subjects";
    protected $primaryKey = "id";
    public $fillable = [
        'code',
        'name',
        'logo',
    ];
    // protected $guarded = [];
    // public $timestamps = true;
    public  function quizs()
    {
        return $this->hasMany(Quiz::class, 'subject_id');
    }
}