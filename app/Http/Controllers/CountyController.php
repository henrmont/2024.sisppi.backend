<?php

namespace App\Http\Controllers;

use App\Models\County;
use App\Models\MinisterialOrdinace;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountyController extends Controller
{
    public function getCounties(): JsonResponse {

        $counties = County::orderBy('id', 'asc')->withCount(['users'])->with(['users'])->get();

        return response()->json([
            "data" => $counties
        ]);

    }

    public function getCounty($id): JsonResponse {

        $county = County::with(['users'])->find($id);

        return response()->json([
            "data" => $county
        ]);

    }

    public function createCounty(Request $request): JsonResponse {
        try {
            DB::beginTransaction();

            $county = County::create([
                'ibge'  => $request->ibge,
                'name'  => $request->name,
                'fu'    => $request->fu,
                'tcu_population_base_year'  => $request->tcu_population_base_year,
                'population'    => $request->population,
                'health_region' => $request->health_region,
                'health_region_code'    => $request->health_region_code,
                'macroregion'   => $request->macroregion,
                'pole_municipality' => $request->pole_municipality,
                'distance_from_pole_municipality'   => $request->distance_from_pole_municipality,
                'distance_from_the_capital' => $request->distance_from_the_capital,
                'img_map'   => $request->img_map,
                'created_at'=> now(),
                'updated_at'=> now(),
            ]);

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Inclusão de município',
                'content'   => 'O município '.$county->name.' foi criado com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Município criado com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function deleteCounty($id): JsonResponse {
        try {
            DB::beginTransaction();

            $county = County::find($id);
            $county->delete();

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Exclusão de município',
                'content'   => 'O município '.$county->name.' foi excluído com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Município deletado com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function updateCounty(Request $request): JsonResponse {
        try {
            DB::beginTransaction();

            $county = County::find($request->id);

            $county->ibge = $request->ibge;
            $county->name = $request->name;
            $county->fu = $request->fu;
            $county->tcu_population_base_year = $request->tcu_population_base_year;
            $county->population = $request->population;
            $county->health_region = $request->health_region;
            $county->health_region_code = $request->health_region_code;
            $county->macroregion = $request->macroregion;
            $county->pole_municipality = $request->pole_municipality;
            $county->distance_from_pole_municipality = $request->distance_from_pole_municipality;
            $county->distance_from_the_capital = $request->distance_from_the_capital;
            $county->img_map = $request->img_map;
            $county->updated_at = now();
            $county->ibge = $request->ibge;

            $county->save();

            Notification::create([
                'user_id'   => auth()->user()->id,
                'title' => 'Atualização de município',
                'content'   => 'O município '.$county->name.' foi atualizado com sucesso.',
            ]);

            DB::commit();

            return response()->json([
                "message" => 'Município atualizado com sucesso.'
            ]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                "message" => 'Erro no sistema.'
            ]);
        }
    }

    public function getCountiesWithoutMinisterialOrdinace($id): JsonResponse {

        $ministerial_ordinace = MinisterialOrdinace::with(['ministerial_ordinace_destinations'])->find($id);
        $allCounties = County::all();
        $counties = [];

        foreach ($allCounties as $chv => $vlr) {
            $perm = true;
            foreach ($ministerial_ordinace->ministerial_ordinace_destinations as $item) {
                if ($vlr['id'] == $item['county_id']) {
                    $perm = false;
                }
            }

            if ($perm) {
                $counties[$chv] = $vlr;
            }
        }

        $counties = array_values($counties);

        return response()->json([
            "data" => $counties
        ]);

    }
}
