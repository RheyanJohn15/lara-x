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
        Schema::create('u_i_teches', function (Blueprint $table) {
            $table->uuid('ui_id')->primary(); 
            $table->string('type', 100);
            $table->string('value');
            $table->uuid('pi_id');
            $table->foreign('pi_id')->references('pi_id')->on('project_infos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('u_i_teches');
    }
};
