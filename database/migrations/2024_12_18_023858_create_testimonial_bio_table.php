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
        Schema::create('testimonial_bio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('testimonial_id')->constrained('testimonial')->onDelete('cascade'); 
            $table->foreignId('bio_id')->constrained('bio')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonial_bio');
    }
};
