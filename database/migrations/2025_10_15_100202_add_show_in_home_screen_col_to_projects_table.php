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
        Schema::table('projects', function (Blueprint $table) {
            $table->boolean('show_in_home_screen')->default(true)->after('is_active');
            $table->dropColumn('city');
            $table->string('city_en')->nullable();
            $table->string('city_ar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('show_in_home_screen');
            $table->string('city')->nullable();
            $table->dropColumn('city_en');
            $table->dropColumn('city_ar');
        });
    }
};
