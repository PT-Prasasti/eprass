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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('company');
            $table->string('company_phone')->unique();
            $table->string('company_email')->unique();
            $table->string('item_specialization')->nullable();
            $table->text('address');
            $table->string('sales_representation');
            $table->string('sales_number')->unique();
            $table->string('sales_email')->unique();
            $table->string('location')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_number')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_swift')->nullable();
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
        Schema::dropIfExists('suppliers');
    }
};
