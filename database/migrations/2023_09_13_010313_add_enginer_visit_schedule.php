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
        Schema::table('visit_schedules', function (Blueprint $table) {
            $table->json('enginer_email')->nullable()->after('schedule');
            $table->string('user_created')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visit_schedules', function (Blueprint $table) {
            $table->json('enginer_email');
            $table->string('user_created');
        });
    }
};
