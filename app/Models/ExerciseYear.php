<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExerciseYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_valid',
        'deleted_at',
    ];

    public function ministerial_ordinaces(): HasMany
    {
        return $this->hasMany(MinisterialOrdinace::class, 'exercise_year_id', 'id');
    }

    public function incentives(): HasMany
    {
        return $this->hasMany(Incentive::class, 'exercise_year_id', 'id');
    }


}
