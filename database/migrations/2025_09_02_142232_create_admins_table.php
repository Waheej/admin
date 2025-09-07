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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('country_code');
            $table->string('mobile');
            $table->string('password');
            $table->string('locale')->default('ar');
            $table->boolean('is_active')->default(1);

            $table->unsignedBigInteger('role_id')->nullable();
            $table->foreign('role_id')
            ->references('id')
            ->on('roles')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            
            $table->string('remember_token')->nullable();
            $table->timestamps();
			$table->softDeletes();

            $table->unique(['country_code','mobile']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
