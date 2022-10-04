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
        Schema::table('english_tests',function(Blueprint $table){
            $table->id();
            $table->enum('level',['ELEMENTARY','INTERMEDIATE','UPPER-INTERMEDIATE']);
            $table->string('text_to_read');
            $table->json('question_1'); // Question + 3 options
            $table->json('question_2');
            $table->json('question_3');
            $table->json('question_4');
            $table->json('question_5');
            $table->json('question_6');
            $table->json('question_7');
            $table->json('question_8');
            $table->json('question_9');
            $table->json('question_10');
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
