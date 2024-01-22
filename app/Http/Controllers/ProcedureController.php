<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use App\Models\Financing;
use App\Models\Group;
use App\Models\Modality;
use App\Models\Notification;
use App\Models\OrganizationForm;
use App\Models\Procedure;
use App\Models\Subgroup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ZipArchive;

class ProcedureController extends Controller
{
    private function getImportedGroups($file) {
        $data = [];

        $zip = new ZipArchive;
        $zip->open($file);

        set_time_limit(0);
        for($i = 0;$i < $zip->numFiles; $i++ ){
            $filename = $zip->getNameIndex($i);
            if ($filename === 'tb_grupo.txt') {
                foreach (file("zip://".$file."#".$filename) as $line) {
                    $reg = [
                        'group_code' => utf8_encode(substr($line,0,2)),
                        'group_name' => utf8_encode(trim(substr($line,2,100))),
                        'competence' => utf8_encode(substr($line,106,2).'/'.substr($line,102,4)),
                    ];

                    array_push($data, $reg);
                }
            }
        }

        return $data;
    }

    private function getImportedSubgroups($file) {
        $data = [];

        $zip = new ZipArchive;
        $zip->open($file);

        set_time_limit(0);
        for($i = 0;$i < $zip->numFiles; $i++ ){
            $filename = $zip->getNameIndex($i);
            if ($filename === 'tb_sub_grupo.txt') {
                foreach (file("zip://".$file."#".$filename) as $line) {
                    $reg = [
                        'subgroup_code' => utf8_encode(substr($line,0,4)),
                        'subgroup_name' => utf8_encode(trim(substr($line,4,100))),
                        'group' => utf8_encode(substr($line,0,2)),
                        'competence' => utf8_encode(substr($line,108,2).'/'.substr($line,104,4)),
                    ];

                    array_push($data, $reg);
                }
            }
        }

        return $data;
    }

    private function getImportedOrganizationForms($file) {
        $data = [];

        $zip = new ZipArchive;
        $zip->open($file);

        set_time_limit(0);
        for($i = 0;$i < $zip->numFiles; $i++ ){
            $filename = $zip->getNameIndex($i);
            if ($filename === 'tb_forma_organizacao.txt') {
                foreach (file("zip://".$file."#".$filename) as $line) {
                    $reg = [
                        'organization_form_code' => utf8_encode(substr($line,0,6)),
                        'organization_form_name' => utf8_encode(trim(substr($line,6,100))),
                        'subgroup' => utf8_encode(substr($line,0,4)),
                        'group' => utf8_encode(substr($line,0,2)),
                        'competence' => utf8_encode(substr($line,110,2).'/'.substr($line,106,4)),
                    ];

                    array_push($data, $reg);
                }
            }
        }

        return $data;
    }

    private function getImportedFinancings($file) {
        $data = [];

        $zip = new ZipArchive;
        $zip->open($file);

        set_time_limit(0);
        for($i = 0;$i < $zip->numFiles; $i++ ){
            $filename = $zip->getNameIndex($i);
            if ($filename === 'tb_financiamento.txt') {
                foreach (file("zip://".$file."#".$filename) as $line) {
                    $reg = [
                        'financing_code' => utf8_encode(substr($line,0,2)),
                        'financing_name' => utf8_encode(trim(substr($line,2,100))),
                        'competence' => utf8_encode(substr($line,106,2).'/'.substr($line,102,4)),
                    ];

                    array_push($data, $reg);
                }
            }
        }

        return $data;
    }

    private function getImportedModalities($file) {
        $data = [];

        $zip = new ZipArchive;
        $zip->open($file);

        set_time_limit(0);
        for($i = 0;$i < $zip->numFiles; $i++ ){
            $filename = $zip->getNameIndex($i);
            if ($filename === 'tb_modalidade.txt') {
                foreach (file("zip://".$file."#".$filename) as $line) {
                    $reg = [
                        'modality_code' => utf8_encode(substr($line,0,2)),
                        'modality_name' => utf8_encode(trim(substr($line,2,100))),
                        'competence' => utf8_encode(substr($line,106,2).'/'.substr($line,102,4)),
                    ];

                    array_push($data, $reg);
                }
            }
        }

        return $data;
    }

    private function getImportedProcedures($file) {
        $data = [];

        $zip = new ZipArchive;
        $zip->open($file);

        set_time_limit(0);
        for($i = 0;$i < $zip->numFiles; $i++ ){
            $filename = $zip->getNameIndex($i);
            if ($filename === 'tb_procedimento.txt') {
                foreach (file("zip://".$file."#".$filename) as $line) {
                    $reg = [
                        'procedure_code' => utf8_encode(substr($line,0,10)),
                        'procedure_name' => utf8_encode(trim(substr($line,10,250))),
                        'group' => utf8_encode(substr($line,0,2)),
                        'subgroup' => utf8_encode(substr($line,0,4)),
                        'organization_form' => utf8_encode(substr($line,0,6)),
                        'hospital_procedure_value' => utf8_encode(substr($line,282,10)),
                        'outpatient_procedure_value' => utf8_encode(substr($line,292,10)),
                        'profissional_procedure_value' => utf8_encode(substr($line,302,10)),
                        'financing' => utf8_encode(substr($line,312,2)),
                        'competence' => utf8_encode(substr($line,328,2).'/'.substr($line,324,4)),
                        'modalities' => [],
                    ];

                    array_push($data, $reg);
                }
            }
        }

        set_time_limit(0);
        for($i = 0;$i < $zip->numFiles; $i++ ){
            $filename = $zip->getNameIndex($i);
            if ($filename === 'rl_procedimento_modalidade.txt') {
                foreach (file("zip://".$file."#".$filename) as $line) {
                    $handle = substr($line,0,10);
                    foreach ($data as $chv => $value) {
                        if ($handle == $value['procedure_code']) {
                            array_push($data[$chv]['modalities'],substr($line,10,2));
                        }
                    }
                }
            }
        }

        return $data;
    }

    public function importProcedures(Request $request): JsonResponse {

        if (is_file($request->file('file'))) {
            $request->validate([
                'file' => 'required',
                'file.*' => 'required|mimes:zip',
            ]);

            $groups = $this->getImportedGroups($request->file('file'));
            $subgroups = $this->getImportedSubgroups($request->file('file'));
            $organization_forms = $this->getImportedOrganizationForms($request->file('file'));
            $financings = $this->getImportedFinancings($request->file('file'));
            $modalities = $this->getImportedModalities($request->file('file'));
            $procedures = $this->getImportedProcedures($request->file('file'));

            try {
                DB::beginTransaction();

                set_time_limit(0);

                $handleCompetence = true;
                foreach ($groups as $vlr) {
                    if ($handleCompetence) {
                        $competence = Competence::where('name',$vlr['competence'])->get();
                        if (count($competence) == 0) {
                            $competence = Competence::create([
                                'name' => $vlr['competence'],
                                'created_at'=> now(),
                                'updated_at'=> now()
                            ]);
                        }
                        $handleCompetence = false;
                    }
                    $group = Group::create([
                        'code' => $vlr['group_code'],
                        'name' => $vlr['group_name'],
                        'competence_id' => $competence->id,
                    ]);
                }

                foreach ($subgroups as $vlr) {
                    $group = Group::where('code',$vlr['group'])->get();
                    $subgroup = Subgroup::create([
                        'code' => $vlr['subgroup_code'],
                        'name' => $vlr['subgroup_name'],
                        'group_id' => $group[0]->id,
                        'competence_id' => $competence->id,
                    ]);
                }

                foreach ($organization_forms as $vlr) {
                    $group = Group::where('code',$vlr['group'])->get();
                    $subgroup = Subgroup::where('code',$vlr['subgroup'])->get();
                    $organization_form = OrganizationForm::create([
                        'code' => $vlr['organization_form_code'],
                        'name' => $vlr['organization_form_name'],
                        'group_id' => $group[0]->id,
                        'subgroup_id' => $subgroup[0]->id,
                        'competence_id' => $competence->id,
                    ]);
                }

                foreach ($financings as $vlr) {
                    $financing = Financing::create([
                        'code' => $vlr['financing_code'],
                        'name' => $vlr['financing_name'],
                        'competence_id' => $competence->id,
                    ]);
                }

                foreach ($modalities as $vlr) {
                    $modality = Modality::create([
                        'code' => $vlr['modality_code'],
                        'name' => $vlr['modality_name'],
                        'competence_id' => $competence->id,
                    ]);
                }

                $modalities = Modality::all();
                foreach ($procedures as $vlr) {
                    $group = Group::where('code',$vlr['group'])->get();
                    $subgroup = Subgroup::where('code',$vlr['subgroup'])->get();
                    $organization_form = OrganizationForm::where('code',$vlr['organization_form'])->get();
                    $financing = Financing::where('code',$vlr['financing'])->get();
                    $procedureModalities = [];
                    foreach ($modalities as $item) {
                        if (in_array($item->code,$vlr['modalities'])) {
                            array_push($procedureModalities, $item->name);
                        }
                    }

                    $procedure = Procedure::create([
                        'code' => $vlr['procedure_code'],
                        'name' => $vlr['procedure_name'],
                        'organization_form_id' => $organization_form[0]->id,
                        'subgroup_id' => $subgroup[0]->id,
                        'group_id' => $group[0]->id,
                        'competence_id' => $competence->id,
                        'hospital_procedure_value' => floatval($vlr['hospital_procedure_value'])/100,
                        'outpatient_procedure_value' => floatval($vlr['outpatient_procedure_value'])/100,
                        'profissional_procedure_value' => floatval($vlr['profissional_procedure_value'])/100,
                        'financing_id' => $financing[0]->id,
                        'modality_code' => $procedureModalities,
                    ]);
                }

                Notification::create([
                    'user_id'   => auth()->user()->id,
                    'title' => 'Importação de procedimentos',
                    'content'   => 'Procedimentos importados com sucesso.',
                ]);

                DB::commit();

                return response()->json([
                    "message" => 'Importação feita com sucesso.'
                ]);
            } catch(\Exception $e) {
                DB::rollBack();

                return response()->json([
                    "message" => 'Erro no sistema'
                ]);
            }
        }

    }

    public function getProcedures(): JsonResponse {

        $procedures = Procedure::with(['competence','financing','group','subgroup','organization_form'])->whereHas('competence', function($q) {
            $q->where('is_valid', true);
        })->orderBy('id', 'asc')->get();

        return response()->json([
            "data" => $procedures
        ]);

    }
}
