<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subgroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'subgroup_code',
        'subgroup_name',
        'group_id',
        'competence_id',
        'is_valid',
        'deleted_at',
    ];
}
