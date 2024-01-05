<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class County extends Model
{
    use HasFactory;

    protected $fillable = [
        'ibge',
        'name',
        'fu',
        'tcu_population_base_year',
        'population',
        'health_region',
        'health_region_code',
        'macroregion',
        'pole_municipality',
        'distance_from_pole_municipality',
        'distance_from_the_capital',
        'img_map',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'county_id', 'id');
    }
}
