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
        Schema::create('english_tests',function(Blueprint $table){
            $table->id();
            $table->string('name');
            $table->enum('level',['ELEMENTARY','INTERMEDIATE','UPPER-INTERMEDIATE']);
            $table->string('text_to_read');
            $table->json('questions');
            $table->string('essay_title');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('english_tests');
    }
};
