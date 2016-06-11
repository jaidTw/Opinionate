<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->tinyInteger('id')->unsigned();
            $table->tinyInteger('question_set_id')->unsigned();
            $table->bigInteger('topic_id')->unsigned();
            $table->string('content');
            $table->primary(['id', 'question_set_id', 'topic_id']);
            $table->foreign(array('question_set_id', 'topic_id'))
                ->references(array('id', 'topic_id'))->on('question_sets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('options');
    }
}
