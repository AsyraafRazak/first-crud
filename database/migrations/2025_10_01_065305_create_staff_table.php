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
        Schema::create('staff', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('gender');
        $table->date('startServiceDate');
        $table->string('position');
        $table->string('department');
        $table->string('email')->unique();
        $table->string('phone')->nullable();
        $table->string('office_location')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
