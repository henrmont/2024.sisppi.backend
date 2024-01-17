<?php

namespace App\Http\Controllers;

use App\Models\OrganizationForm;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationFormController extends Controller
{
    public function getOrganizationForms(): JsonResponse {

        $organization_forms = OrganizationForm::with(['competence'])->whereHas('competence', function($q) {
            $q->where('is_valid', true);
        })->orderBy('id', 'asc')->get();

        return response()->json([
            "data" => $organization_forms
        ]);

    }
}
