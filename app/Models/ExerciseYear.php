<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'exercise_year',
        'deleted_at',
    ];
}
