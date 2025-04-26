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
        Schema::create('current_alternatives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('current_user_ranking_id')->constrained('current_users_rankings')->onDelete('cascade');
            $table->foreignId('alternative_id')->constrained('alternatives');
            $table->string('alternative_name');
            $table->double('score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_alternatives');
    }
};
