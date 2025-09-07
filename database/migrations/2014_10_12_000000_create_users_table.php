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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('country_code');
            $table->string('mobile');
            $table->string('password');
            $table->string('email');

            $table->boolean('otp_verified')->default(0);
            $table->string('otp_secret')->nullable();
            $table->timestamp('otp_created_at')->nullable();

            $table->unsignedBigInteger('authenticatable_id')->nullable();
            $table->string('authenticatable_type')->nullable();

            $table->string('locale')->default('ar');
            $table->string('uuid')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
