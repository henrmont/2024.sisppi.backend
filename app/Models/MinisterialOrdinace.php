<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MinisterialOrdinace extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'name',
        'number',
        'value',
        'type',
        'observation',
        'exercise_year_id',
        'competence_id',
        'file',
        'is_valid',
        'deleted_at',
    ];

    public function exercise_year(): BelongsTo
    {
        return $this->belongsTo(ExerciseYear::class, 'exercise_year_id', 'id');
    }

    public function competence(): BelongsTo
    {
        return $this->belongsTo(Competence::class, 'competence_id', 'id');
    }
}
