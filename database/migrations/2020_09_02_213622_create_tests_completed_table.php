<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsCompletedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests_completed', function (Blueprint $table) {
            $table->id("test_completed_id");

            $table->unsignedBigInteger("lesson_id");
            $table->foreign("lesson_id")->references("lesson_completed_id")->on("lessons_completed")->onDelete("cascade");

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
