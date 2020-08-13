<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBasUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::enableForeignKeyConstraints();
        Schema::create('bas_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 255)->unique();
            $table->string('password', 255);
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('phone', 255);
            $table->string('address', 255);
            $table->string('is_active', 1);
            $table->string('activation_code', 32);
            $table->string('priv_admin', 1);
            $table->smallInteger('is_email_valid')->nullable();
            $table->string('new_email_candidate',255)->nullable();
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
