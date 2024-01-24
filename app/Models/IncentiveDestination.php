<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncentiveDestination extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'incentive_id',
        'county_id',
        'is_valid',
        'deleted_at',
    ];

    public function incentive(): BelongsTo
    {
        return $this->belongsTo(Incentive::class, 'incentive_id', 'id');
    }

    public function county(): BelongsTo
    {
        return $this->belongsTo(County::class, 'county_id', 'id');
    }
}
