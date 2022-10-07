<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizUserAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_user_answers', function (Blueprint $table) {
            $table->bigIncrements('quiz_user_answer_id');
            $table->unsignedBigInteger('quiz_user_id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('choice_id');
            $table->boolean('is_correct')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('question_id')
            ->references('question_id')
            ->on('questions')
            ->onDelete('cascade');

            $table->foreign('quiz_user_id')
            ->references('quiz_user_id')
            ->on('quiz_users')
            ->onDelete('cascade');

            $table->foreign('choice_id')
            ->references('choice_id')
            ->on('question_choices')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_user_answers');
    }
}
