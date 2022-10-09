<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_results', function (Blueprint $table) {

            $table->id("test_result_id");

            $table->unsignedBigInteger("question_id");
            $table->foreign("question_id")->references("question_id")->on("questions")->onDelete("cascade");

            $table->unsignedBigInteger("answer_id");
            $table->foreign("answer_id")->references("answer_id")->on("answers")->onDelete("cascade");

            $table->unsignedBigInteger("test_completed_id");
            $table->foreign("test_completed_id")->references("test_completed_id")->on("tests_completed")->onDelete("cascade");

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
        Schema::dropIfExists('tests_completed');
    }
}
