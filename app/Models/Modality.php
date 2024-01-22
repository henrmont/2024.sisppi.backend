<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Modality extends Model
{
    use HasFactory;

    protected $table = 'modalities';

    protected $fillable = [
        'code',
        'name',
        'competence_id',
        'is_valid',
        'deleted_at',
    ];

    public function competence(): BelongsTo
    {
        return $this->belongsTo(Competence::class, 'competence_id', 'id');
    }
}
