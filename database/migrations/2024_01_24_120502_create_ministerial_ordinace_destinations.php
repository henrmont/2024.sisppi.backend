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
        Schema::create('ministerial_ordinace_destinations', function (Blueprint $table) {
            $table->id();
            $table->float('value', 20, 2)->default(0);
            $table->integer('ministerial_ordinace_id');
            $table->integer('county_id');
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
        Schema::dropIfExists('ministerial_ordinace_destinations');
    }
};
