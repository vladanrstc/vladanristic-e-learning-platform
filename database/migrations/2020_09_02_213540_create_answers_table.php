<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id("answer_id");
            $table->string("answer_text");
            $table->boolean("answer_true");
            $table->timestamps();

            // foreign key to the questions table
            $table->unsignedBigInteger("question_id");
            $table->foreign("question_id")->references("question_id")->on("questions")->onDelete("cascade");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
}
