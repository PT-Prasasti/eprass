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
        Schema::create('payment_request_exims', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->uuid('uuid');
            $table->string('subject');
            $table->date('submission_date');
            $table->string('name');
            $table->string('position');

            $table->string('bank_name');
            $table->string('bank_account');
            $table->string('bank_swift');
            $table->string('bank_number');
            $table->string('status');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_request_exims');
    }
};
