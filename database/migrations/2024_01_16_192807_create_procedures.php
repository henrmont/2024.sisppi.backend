<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('procedures', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->integer('organization_form_id');
            $table->integer('subgroup_id');
            $table->integer('group_id');
            $table->integer('competence_id');
            $table->float('hospital_procedure_value',16,2);
            $table->float('outpatient_procedure_value',16,2);
            $table->float('profissional_procedure_value',16,2);
            $table->integer('financing_id');
            $table->json('modality_code')->nullable();
            $table->boolean('is_valid')->default(true);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedures');
    }
};
