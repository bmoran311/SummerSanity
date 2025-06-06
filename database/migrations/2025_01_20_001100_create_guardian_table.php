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
        Schema::create('guardian', function (Blueprint $table) {
            $table->id();            
            $table->string('first_name');            
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone_number'); 
            $table->string('zip_code', 50);                  
            $table->string('communication_preference', 50); 
            $table->boolean('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guardian');
    }
};