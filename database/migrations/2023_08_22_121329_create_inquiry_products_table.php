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
        Schema::create('inquiry_products', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('inquiry_id');
            $table->string('item_name');
            $table->text('description');
            $table->string('size');
            $table->integer('qty');
            $table->string('remark');
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
        Schema::dropIfExists('inquiry_products');
    }
};
