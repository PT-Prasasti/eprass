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
        Schema::create('payment_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('purchase_order_supplier_id');
            $table->date('transaction_date');
            $table->date('transaction_due_date');
            $table->string('transaction_code')->nullable();

            $table->double('value')->default(0);
            $table->string('note')->nullable();

            $table->string('pick_up_information_name')->nullable();
            $table->string('pick_up_information_email')->nullable();
            $table->string('pick_up_information_phone_number')->nullable();
            $table->string('pick_up_information_mobile_number')->nullable();
            $table->text('pick_up_information_pick_up_address')->nullable();

            $table->json('document_list')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('payment_requests');
    }
};
