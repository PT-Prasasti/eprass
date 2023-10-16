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
        Schema::table('inquiry_products', function (Blueprint $table) {
            $table->string('delivery_time')->nullable()->after('remark');
            $table->integer('sourcing_qty')->default(0)->after('delivery_time');
            $table->string('currency')->nullable()->after('sourcing_qty');
            $table->double('price', 50, 10)->default(0)->after('currency');
            $table->double('shipping_fee', 5, 2)->default(0)->after('price');
            $table->double('profit', 5, 2)->default(0)->after('shipping_fee');
            $table->double('cost', 50, 10)->default(0)->after('profit');
            $table->double('total_cost', 50, 10)->default(0)->after('cost');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inquiry_products', function (Blueprint $table) {
            $table->dropColumn([
                'delivery_time',
                'sourcing_qty',
                'currency',
                'price',
                'shipping_fee',
                'profit',
                'cost',
                'total_cost',
            ]);
        });
    }
};
