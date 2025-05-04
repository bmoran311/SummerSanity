<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('invitation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guardian_id')->constrained('guardian')->onDelete('cascade'); // Inviter
            $table->string('email'); // Invitee email
            $table->enum('status', ['pending', 'accepted', 'declined'])->default('pending');
            $table->foreignId('guardian_id2')->nullable()->constrained('guardian')->onDelete('set null'); // Invitee once they join
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invitation');
    }
};