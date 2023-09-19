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
        Schema::create('purchasings', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('quotation_id');
            $table->text('excel');
            $table->text('folder')->nullable();
            $table->longText('documents')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('quotation_id')->references('id')->on('quotations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchasings');
    }
};
