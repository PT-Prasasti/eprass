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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->uuid();
            $table->string('visit_schedule_id');
            $table->foreignId('sales_id');
            $table->date('due_date')->nullable();
            $table->string('subject');
            $table->integer('grade');
            $table->text('description')->nullable();
            $table->text('files')->nullable();
            $table->string('status')->default('waiting');
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
        Schema::dropIfExists('inquiries');
    }
};
