<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCmsCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_course', function (Blueprint $table) {
            $table->increments('id');
            $table->string('course_fullname', 128);
            $table->string('course_shortname', 100);
            $table->string('course_idnumber', 128);
            $table->string('course_category', 100)->nullable();
            $table->integer('course_duration', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_course');
    }
}
