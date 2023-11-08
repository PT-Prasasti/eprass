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
        Schema::table('quotation_items', function (Blueprint $table) {
            $table->text('item_name_of_purchase_order_customer')->nullable()->after('total_cost');
            $table->date('max_delivery_time_of_purchase_order_customer')->nullable()->after('item_name_of_purchase_order_customer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotation_items', function (Blueprint $table) {
            $table->dropColumn([
                'item_name_of_purchase_order_customer',
                'max_delivery_time_of_purchase_order_customer',
            ]);
        });
    }
};
