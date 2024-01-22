<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Programing extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'exercise_year_id',
        'county_id',
        'is_valid',
        'deleted_at',
    ];

    public function exercise_year(): BelongsTo
    {
        return $this->belongsTo(ExerciseYear::class, 'exercise_year_id', 'id');
    }

    public function county(): BelongsTo
    {
        return $this->belongsTo(County::class, 'county_id', 'id');
    }

    public function procedures(): HasMany
    {
        return $this->hasMany(ProgramingProcedure::class, 'programing_id', 'id');
    }
}
