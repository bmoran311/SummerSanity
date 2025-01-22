<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camp', function (Blueprint $table) {            
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('activity');
            $table->integer('min_age');
            $table->integer('max_age');
            $table->string('registration_link')->nullable();
            $table->date('registration_end_date')->nullable();
            $table->decimal('price', 8, 2);
            $table->decimal('early_bird_price', 8, 2)->nullable();
            $table->date('early_bird_price_end_date')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('shift', ['Morning', 'Afternoon', 'Night', 'All-day']);
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('location');
            $table->string('location_address');
            $table->string('location_city');
			$table->string('location_state');
            $table->string('location_zip');
            $table->integer('capacity');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('camp');
    }
};