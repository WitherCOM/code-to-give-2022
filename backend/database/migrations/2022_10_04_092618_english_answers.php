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
            $table->foreignId('link_id')->references('id')->on('links')->onDelete('cascade');
            $table->json('answers');
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
