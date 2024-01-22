<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Procedure extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'organization_form_id',
        'subgroup_id',
        'group_id',
        'competence_id',
        'hospital_procedure_value',
        'outpatient_procedure_value',
        'profissional_procedure_value',
        'financing_id',
        'modality_code',
        'is_valid',
        'deleted_at',
    ];

    protected $casts = [
        'modality_code' => 'array',
    ];

    public function competence(): BelongsTo
    {
        return $this->belongsTo(Competence::class, 'competence_id', 'id');
    }

    public function financing(): BelongsTo
    {
        return $this->belongsTo(Financing::class, 'financing_id', 'id');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

    public function subgroup(): BelongsTo
    {
        return $this->belongsTo(Subgroup::class, 'subgroup_id', 'id');
    }

    public function organization_form(): BelongsTo
    {
        return $this->belongsTo(OrganizationForm::class, 'organization_form_id', 'id');
    }

}
