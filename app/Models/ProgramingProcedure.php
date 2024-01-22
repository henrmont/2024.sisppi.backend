<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramingProcedure extends Model
{
    use HasFactory;

    protected $fillable = [
        'programing_id',
        'procedure_id',
        'amount',
        'type',
        'is_valid',
        'deleted_at',
    ];

    public function programing(): BelongsTo
    {
        return $this->belongsTo(Programing::class, 'programing_id', 'id');
    }

    public function procedure(): BelongsTo
    {
        return $this->belongsTo(Procedure::class, 'procedure_id', 'id');
    }

}
