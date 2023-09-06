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
        Schema::create('visit_reports', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('visit_schedule_id');
            $table->foreignId('sales_id');
            $table->string('status')->nullable();
            $table->string('note')->nullable();
            $table->string('planing')->nullable();
            $table->date('next_date_visit')->nullable();
            $table->time('next_time_visit')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('visit_schedule_id')->references('id')->on('visit_schedules');
            $table->foreign('sales_id')->references('id')->on('sales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visit_reports');
    }
};
