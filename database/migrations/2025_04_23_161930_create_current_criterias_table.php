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
        Schema::create('current_criterias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('current_alternative_id')->constrained('current_alternatives')->onDelete('cascade');
            $table->foreignId('criteria_id')->constrained('criterias');
            $table->string('criteria_name');
            $table->integer('criteria_value');
            $table->foreignId('sub_criteria_id')->constrained('sub_criterias');
            $table->string('sub_criteria_name');
            $table->integer('sub_criteria_value');
            $table->double('score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_sub_criterias');
    }
};
