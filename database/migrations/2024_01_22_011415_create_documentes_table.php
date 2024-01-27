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
        Schema::create('documentes', function (Blueprint $table) {
            $table->id();
            $table->string("filename")->nullable();
            $table->text("path")->nullable();
            $table->string("related_table")->nullable();
            $table->string("related_id")->nullable();
            $table->string("file_size")->nullable();
            $table->string("file_type")->nullable();
            $table->string("doc_type")->nullable();
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
        Schema::dropIfExists('documentes');
    }
};
