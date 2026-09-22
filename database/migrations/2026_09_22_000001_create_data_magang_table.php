<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_magang', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nim')->unique();
            $table->string('program_studi');
            $table->string('tempat_magang');
            $table->string('pembimbing_lapangan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_magang');
    }
};
