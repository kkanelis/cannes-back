<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('summary');
            $table->string('director');
            $table->string('year');
            $table->string('country');
            $table->integer('duration_minutes');
            $table->json('credits')->nullable();
            $table->json('casting')->nullable();
            $table->string('poster_url');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};