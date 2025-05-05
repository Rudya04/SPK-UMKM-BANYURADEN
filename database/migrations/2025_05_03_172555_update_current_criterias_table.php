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
        Schema::table('current_criterias', function (Blueprint $table) {
            $table->double('value_normal');
            $table->double('bobot_normal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('current_criterias', function (Blueprint $table) {
            $table->dropColumn('value_normal');
            $table->dropColumn('bobot_normal');
        });
    }
};
