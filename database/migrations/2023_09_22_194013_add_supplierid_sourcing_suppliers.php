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
            $table->foreignId('supplier_id')->after('sourcing_id');
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
            $table->dropColumn('supplier_id');
        });
    }
};
