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
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('country_code', 10)->nullable();
            $table->string('mobile', 15)->nullable();
            $table->string('email')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};
