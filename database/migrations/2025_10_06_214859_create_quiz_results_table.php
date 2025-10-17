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
        Schema::create('quiz_results', function (Blueprint $table) {
            $table->uuid('id')->primary();            // Unique ID
            $table->string('email');                  // User email
            $table->string('result_type');            // Personality/result type
            $table->json('answers');                  // Stores quiz answers as JSON
            $table->string('source')->nullable();     // Optional: landing page, ad, etc.
            $table->timestamps();                     // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_results');
    }
};
