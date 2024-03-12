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
        Schema::create('purchase_order_suppliers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sales_order_id');
            $table->uuid('supplier_id')->nullable();
            $table->date('transaction_date');
            $table->string('transaction_code')->nullable();

            $table->string('term')->nullable();
            $table->string('payment_term')->nullable();
            $table->string('delivery')->nullable();
            $table->string('vat')->nullable();
            $table->string('note')->nullable();
            $table->string('attachment')->nullable();

            $table->string('bank_name')->nullable();
            $table->string('bank_swift')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_number')->nullable();
            $table->string('invoice_url')->nullable();

            $table->string('total_shipping_note')->nullable();
            $table->double('total_shipping_value')->default(0);

            $table->json('document_list')->nullable();
            $table->string('status');
            $table->string('reason')->nullable();
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
        Schema::dropIfExists('purchase_order_suppliers');
    }
};
