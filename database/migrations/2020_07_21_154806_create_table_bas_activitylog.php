<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBasActivitylog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bas_activitylog', function (Blueprint $table) {
            $table->increments('id');
            $table->timestampTz('inserted_date')->nullable();
            $table->string('username',90);
            $table->string('application',200);
            $table->string('creator',30);
            $table->string('ip_user',32);
            $table->string('action',30);
            $table->text('description')->nullable();
            $table->string('user_agent',255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_bas_activitylog');
    }
}
