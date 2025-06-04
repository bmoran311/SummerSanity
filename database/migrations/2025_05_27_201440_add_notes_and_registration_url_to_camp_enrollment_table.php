<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('camp_enrollment', function (Blueprint $table) {
            $table->text('notes')->nullable()->after('end_time');
            $table->string('registration_url', 555)->nullable()->after('notes');
        });
    }

    public function down()
    {
        Schema::table('camp_enrollment', function (Blueprint $table) {
            $table->dropColumn(['notes', 'registration_url']);
        });
    }
};
