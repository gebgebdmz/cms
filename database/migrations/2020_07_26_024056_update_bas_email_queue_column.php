<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBasEmailQueueColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bas_email_queue', function (Blueprint $table) {
            $table->increments('id');
            $table->string('destination_email', 255);
            $table->text('email_body');
            $table->string('email_subject',255);
            $table->timestamptz('created_at');
            $table->timestamptz('sent_at')->nullable();
            $table->smallInteger('is_processed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bas_email_queue');
    }
}
