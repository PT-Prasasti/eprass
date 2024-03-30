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
        if (Schema::hasColumn('b_t_b_items', 'b_t_b_id')) {
            Schema::table('b_t_b_items', function (Blueprint $table) {
                $table->dropColumn('b_t_b_id');
            });
        }

        Schema::table('b_t_b_items', function (Blueprint $table) {
            $table->string('b_t_b_id')->after('id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('b_t_b_items', function (Blueprint $table) {
            //
        });
    }
};
