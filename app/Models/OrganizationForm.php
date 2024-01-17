<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
