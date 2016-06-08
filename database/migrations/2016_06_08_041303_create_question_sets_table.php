<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_sets', function (Blueprint $table) {
            $table->tinyInteger('id')->unsigned();
            $table->bigInteger('topic_id')->unsigned();
            $table->string('name');
            $table->enum('type', ['GENERAL', 'LOCATION', 'TIME', 'IMAGE', 'AUDIO', 'VIDEO']);
            $table->boolean('is_multiple_choice');
            $table->boolean('is_synced');
            $table->boolean('is_anonymous');
            $table->enum('result_visibility', ['VISIBLE', 'VISIBLE_AFTER_ENDED', 'INVISIBLE']);
            $table->primary(['id', 'topic_id']);
            $table->foreign('topic_id')->references('id')->on('topics');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('question_sets');
    }
}
