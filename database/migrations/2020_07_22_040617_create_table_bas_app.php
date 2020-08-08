<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBasApp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::enableForeignKeyConstraints();
        Schema::create('bas_app', function (Blueprint $table) {
            $table->increments('id');
            $table->string('app_name', 128)->unique();
            $table->string('app_type', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('menu_name', 255)->nullable();
            $table->string('menu_url', 255)->nullable();
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
