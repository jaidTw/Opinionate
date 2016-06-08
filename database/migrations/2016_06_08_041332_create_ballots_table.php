<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBallotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ballots', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('topic_id')->unsigned();
            $table->tinyInteger('question_set_id')->unsigned();
            $table->tinyInteger('option_id')->unsigned();
            $table->timestamp('cast_at');
            $table->primary(['user_id', 'topic_id', 'question_set_id', 'option_id']);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('topic_id')->references('id')->on('topics');
            $table->foreign('question_set_id')->references('id')->on('question_sets');
            $table->foreign('option_id')->references('id')->on('options');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ballots');
    }
}
