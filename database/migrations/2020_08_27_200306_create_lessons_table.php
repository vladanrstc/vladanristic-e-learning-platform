<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id("lesson_id");
            $table->string('lesson_title');
            $table->text('lesson_description');
            $table->string('lesson_practice', 1024)->nullable();
            $table->string('lesson_code', 1024)->nullable();
            $table->string('lesson_video_link', 1024)->nullable();
            $table->string('lesson_slug', 1024)->nullable();
            $table->integer('lesson_order')->nullable();
            $table->boolean('lesson_published')->nullable();

            // foreign key to the sections table
            $table->unsignedBigInteger("lesson_section_id");
            $table->foreign("lesson_section_id")->references("section_id")->on("sections")->onDelete("cascade");

            $table->unsignedBigInteger("lesson_test_id")->nullable();
            $table->foreign("lesson_test_id")->references("test_id")->on("tests")->onDelete("set null");

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
        Schema::dropIfExists('lessons');
    }
}
