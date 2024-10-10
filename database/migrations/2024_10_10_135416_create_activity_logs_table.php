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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id('act_id');
            $table->string('act_header');
            $table->string('act_action');
            $table->string('act_model');
            $table->string('act_model_id');
            $table->unsignedBigInteger('access_token_id');
            $table->foreign('access_token_id')->references('id')->on('personal_access_tokens');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
