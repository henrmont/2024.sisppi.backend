<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_form_code',
        'organization_form_name',
        'subgroup_id',
        'group_id',
        'competence_id',
        'is_valid',
        'deleted_at',
    ];

    public function competence(): BelongsTo
    {
        return $this->belongsTo(Competence::class, 'competence_id', 'id');
    }


}
