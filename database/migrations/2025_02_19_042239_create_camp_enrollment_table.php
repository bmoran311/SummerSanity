<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
    public function up()
    {
        Schema::create('camp_enrollment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('camper_id')->constrained('camper')->onDelete('cascade');
            $table->foreignId('week_id')->constrained('week')->onDelete('cascade');
            $table->uuid('group_id')->default(Str::uuid());
            $table->string('camp_name');
            $table->enum('time_slot', ['AM', 'PM', 'Night']);
            $table->boolean('booked')->default(false);
            $table->string('type');
            $table->string('start_day')->nullable();
            $table->string('end_day')->nullable();  
            $table->time('start_time')->nullable(); 
            $table->time('end_time')->nullable();   
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('camp_enrollment');
    }
};
