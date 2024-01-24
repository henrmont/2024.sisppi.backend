<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MinisterialOrdinaceDestination extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'ministerial_ordinace_id',
        'county_id',
        'is_valid',
        'deleted_at',
    ];

    public function ministerial_ordinace(): BelongsTo
    {
        return $this->belongsTo(MinisterialOrdinace::class, 'ministerial_ordinace_id', 'id');
    }

    public function county(): BelongsTo
    {
        return $this->belongsTo(County::class, 'county_id', 'id');
    }
}
