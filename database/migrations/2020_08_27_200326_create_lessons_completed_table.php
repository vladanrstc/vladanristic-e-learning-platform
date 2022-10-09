<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsCompletedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons_completed', function (Blueprint $table) {
            $table->id("lesson_completed_id");
            $table->boolean("lesson_completed_flag")->nullable();

            // foreign key to the lessons table
            $table->unsignedBigInteger("lesson_id");
            $table->foreign("lesson_id")->references("lesson_id")->on("lessons")->onDelete("cascade");

            // foreign key to the user_courses_started table
            $table->unsignedBigInteger("course_started_id");
            $table->foreign("course_started_id")->references("user_course_started_id")->on("user_courses_started")->onDelete("cascade");

            $table->unique(["course_started_id", "lesson_id"]);

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
        Schema::dropIfExists('lessons_completed');
    }
}
