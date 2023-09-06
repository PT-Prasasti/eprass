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
        Schema::create('visit_schedules', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->uuid();
            $table->foreignId('customer_id');
            $table->foreignId('sales_id');
            $table->string('visit_by');
            $table->string('devision')->nullable();
            $table->date('date');
            $table->time('time')->nullable();
            $table->text('note')->nullable();
            $table->string('status')->default('loading');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('customer_id')->references('id')->on('customers');
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
        Schema::dropIfExists('visit_schedules');
    }
};
