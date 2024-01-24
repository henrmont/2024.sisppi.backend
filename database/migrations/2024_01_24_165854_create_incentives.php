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
        Schema::create('incentives', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('name');
            $table->string('number');
            $table->float('value', 20, 2);
            $table->string('type');
            $table->text('observation');
            $table->integer('exercise_year_id');
            $table->integer('competence_id');
            $table->text('file')->nullable();
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
        Schema::dropIfExists('incentives');
    }
};
