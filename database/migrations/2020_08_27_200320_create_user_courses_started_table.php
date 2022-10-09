<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCoursesStartedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_courses_started', function (Blueprint $table) {
            $table->id("user_course_started_id");
            $table->text("user_course_started_review_text")->nullable();
            $table->integer("user_course_started_review_mark")->nullable();
            $table->text("user_course_started_note")->nullable();

            // foreign key to the users table
            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");

            // foreign key to the courses table
            $table->unsignedBigInteger("course_id");
            $table->foreign("course_id")->references("course_id")->on("courses")->onDelete("cascade");

            // unique index for user_id and course_id
            $table->unique(['course_id', 'user_id']);

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
        Schema::dropIfExists('user_courses_started');
    }
}
