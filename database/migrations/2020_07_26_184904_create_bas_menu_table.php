<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bas_menu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('app_name',255)->references('id')->on('bas_app')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('parent_menu_id')->nullable();
            $table->integer('role_id')->references('id')->on('bas_role')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bas_user');
    }
}
