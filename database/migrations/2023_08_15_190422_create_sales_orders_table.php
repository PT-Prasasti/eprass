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
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->uuid();
            $table->string('inquiry_id');
            $table->date('due_date');
            $table->text('files')->nullable();
            $table->string('status')->default('loading');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('inquiry_id')->references('id')->on('inquiries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_orders');
    }
};
