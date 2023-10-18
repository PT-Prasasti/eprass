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
        Schema::table('sourcing_suppliers', function (Blueprint $table) {
            $table->string('inquiry_product_id')->nullable()->after('currency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sourcing_suppliers', function (Blueprint $table) {
            $table->dropColumn('inquiry_product_id');
        });
    }
};
