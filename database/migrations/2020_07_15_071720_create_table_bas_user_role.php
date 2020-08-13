<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBasUserRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::enableForeignKeyConstraints();
        Schema::create('bas_user_role', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id');
            $table->integer('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('bas_user')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('role_id')->references('id')->on('bas_role')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
