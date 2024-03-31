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
        Schema::create('payment_request_items', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('payment_request_id');
            $table->date('date');
            $table->string('item');
            $table->text('description');
            $table->string('amount');
            $table->string('remark');
            $table->string('file_document')->nullable();
            $table->timestamps();

            $table->softDeletes();

            $table->foreign('payment_request_id')->references('id')->on('payment_request_exims')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_request_items');
    }
};