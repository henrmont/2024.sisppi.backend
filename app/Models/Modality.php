<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modality extends Model
{
    use HasFactory;

    protected $table = 'modalities';

    protected $fillable = [
        'modality_code',
        'modality_name',
        'competence_id',
        'is_valid',
        'deleted_at',
    ];
}
