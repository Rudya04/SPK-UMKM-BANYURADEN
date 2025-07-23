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
        Schema::table('users_rankings', function (Blueprint $table): void {
            $table->foreignId('form_id')->nullable()->constrained('forms')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_rankings', function (Blueprint $table): void {
            $table->dropForeign(['form_id']);
            $table->dropColumn('form_id');
        });
    }
};
