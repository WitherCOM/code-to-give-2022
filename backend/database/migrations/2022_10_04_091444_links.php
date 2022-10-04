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
        Schema::create('links',function (Blueprint $table){
           $table->uuid();
           $table->foreignId('customer_id')->references('id')->on('customers')->onDelete('cascade');
           $table->foreignId('test_id');
           $table->string('test_type');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('links');
    }
};
