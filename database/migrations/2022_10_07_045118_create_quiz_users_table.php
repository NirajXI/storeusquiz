<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_users', function (Blueprint $table) {
            $table->bigIncrements('quiz_user_id');
            $table->unsignedBigInteger('quiz_id');
            $table->string('email');
            $table->integer('points');
            $table->boolean('is_complete')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('quiz_id')
            ->references('quiz_id')
            ->on('quizzes')
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
        Schema::dropIfExists('quiz_users');
    }
}
