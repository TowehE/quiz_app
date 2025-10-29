<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quiz_results', function (Blueprint $table) {
            $table->string('result_type')->nullable()->change();
            $table->json('answers')->nullable()->change();
            $table->integer('score')->nullable()->change();
            $table->string('source')->nullable()->change();
        });
    }
};