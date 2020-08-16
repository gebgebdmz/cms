<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBasRoleApp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('bas_role_app', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id');
            $table->integer('app_id');
            $table->string('priv_access',1)->nullable()->default('N');
            $table->string('priv_insert',1)->nullable()->default('N');
            $table->string('priv_delete',1)->nullable()->default('N');
            $table->string('priv_update',1)->nullable()->default('N');
            $table->string('priv_export',1)->nullable()->default('N');
            $table->string('priv_print',1)->nullable()->default('N');
            $table->string('app_name',255);
            $table->foreign('role_id')->references('id')->on('bas_role')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('app_name')->references('app_name')->on('bas_app')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
