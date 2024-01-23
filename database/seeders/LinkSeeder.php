<?php

namespace Database\Seeders;

use App\Models\Link;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('links')->insert(
            [
                [
                    'name'      => 'Usuários',
                    'icon'      => 'groups',
                    'url'       => '/usuarios',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'name'      => 'Municípios',
                    'icon'      => 'place',
                    'url'       => '/municipios',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'name'      => 'Regras e permissões',
                    'icon'      => 'rule',
                    'url'       => '/regras',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'name'      => 'Anos de exercício e competências',
                    'icon'      => 'calendar_month',
                    'url'       => '/anos/de/exercicio',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'name'      => 'Grupos, Subgrupos e Formas de organização',
                    'icon'      => 'format_list_numbered',
                    'url'       => '/grupos',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'name'      => 'Financiamentos e Modalidades',
                    'icon'      => 'attach_money',
                    'url'       => '/financiamentos/modalidades',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'name'      => 'Procedimentos',
                    'icon'      => 'medical_services',
                    'url'       => '/procedimentos',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'name'      => 'Programação',
                    'icon'      => 'checklist',
                    'url'       => '/programacao',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ],
                [
                    'name'      => 'Portarias ministeriais',
                    'icon'      => 'request_page',
                    'url'       => '/portarias/ministeriais',
                    'created_at'=> now(),
                    'updated_at'=> now()
                ]
            ]
        );
    }
}
