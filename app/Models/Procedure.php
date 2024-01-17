<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    use HasFactory;

    protected $fillable = [
        'procedure_code',
        'procedure_name',
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

}
