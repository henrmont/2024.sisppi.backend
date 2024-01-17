<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financing extends Model
{
    use HasFactory;

    protected $fillable = [
        'financing_code',
        'financing_name',
        'competence_id',
        'is_valid',
        'deleted_at',
    ];
}
