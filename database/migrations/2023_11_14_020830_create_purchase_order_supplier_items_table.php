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
        Schema::create('purchase_order_supplier_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('purchase_order_supplier_id');
            $table->uuid('selected_sourcing_supplier_id');
            $table->double('quantity')->default(0);
            $table->double('cost')->default(0);
            $table->double('price')->default(0);
            $table->string('delivery_time')->nullable();
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
        Schema::dropIfExists('purchase_order_supplier_items');
    }
};
