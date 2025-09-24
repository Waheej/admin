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
        Schema::create('s_e_o_s', function (Blueprint $table) {
            $table->id();
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('keywords_en')->nullable();
            $table->text('keywords_ar')->nullable();
            $table->string('url')->nullable();
            $table->string('og_title_en')->nullable();
            $table->string('og_title_ar')->nullable();
            $table->text('og_description_en')->nullable();
            $table->text('og_description_ar')->nullable();
            $table->string('og_url')->nullable();
            $table->string('twitter_title_en')->nullable();
            $table->string('twitter_title_ar')->nullable();
            $table->text('twitter_description_en')->nullable();
            $table->text('twitter_description_ar')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('robots')->nullable();
            $table->string('page')->nullable(); //enum
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s_e_o_s');
    }
};
