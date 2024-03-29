<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    use HasFactory;

    protected $table = 'competencies';

    protected $fillable = [
        'name',
        'is_valid',
        'deleted_at',
    ];
}
