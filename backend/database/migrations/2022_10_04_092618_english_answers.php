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
        Schema::create('english_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('english_test_id')->references('id')->on('english_tests')->onDelete('cascade');
            $table->foreignId('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->tinyInteger('answer_1');
            $table->tinyInteger('answer_2');
            $table->tinyInteger('answer_3');
            $table->tinyInteger('answer_4');
            $table->tinyInteger('answer_5');
            $table->tinyInteger('answer_6');
            $table->tinyInteger('answer_7');
            $table->tinyInteger('answer_8');
            $table->tinyInteger('answer_9');
            $table->tinyInteger('answer_10');
            $table->string('essay',2000);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('english_answers');
    }
};
