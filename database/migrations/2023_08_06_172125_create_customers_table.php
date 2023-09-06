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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('alternate')->unique()->nullable();
            $table->string('company');
            $table->string('company_phone')->unique();
            $table->string('company_fax')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->text('address');
            $table->text('note')->nullable();
            $table->foreignId('sales_id');
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('customers');
    }
};
