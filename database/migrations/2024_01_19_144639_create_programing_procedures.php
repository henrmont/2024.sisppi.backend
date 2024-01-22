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
        Schema::create('programing_procedures', function (Blueprint $table) {
            $table->id();
            $table->integer('programing_id');
            $table->integer('procedure_id');
            $table->integer('amount')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('programing_procedures');
    }
};
