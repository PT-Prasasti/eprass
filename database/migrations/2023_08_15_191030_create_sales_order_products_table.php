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
        Schema::create('sales_order_products', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('so_id');
            $table->string('item_name');
            $table->text('description');
            $table->string('size');
            $table->integer('qty');
            $table->string('status')->default('loading');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('so_id')->references('id')->on('sales_orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_order_products');
    }
};
