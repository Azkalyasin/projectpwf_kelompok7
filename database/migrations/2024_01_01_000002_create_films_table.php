<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('poster')->nullable();
            $table->string('trailer')->nullable();
            $table->text('sinopsis')->nullable();
            $table->year('tahun_rilis')->nullable();
            $table->integer('durasi')->nullable()->comment('dalam menit');
            $table->string('sutradara')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
