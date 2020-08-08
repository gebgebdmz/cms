<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableScTbsess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_tbsess', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sess_id',32);
            $table->string('sess_last_access',32)->nullable();
            $table->text('sess_data');
            $table->integer('user_id');
            $table->string('ip_address',255);
            $table->text('user_agent');
            $table->text('payload');
            $table->integer('last_activity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sc_tbsess');
    }
}
