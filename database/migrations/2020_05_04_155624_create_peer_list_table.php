<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeerListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peer_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('participant_id')->unsigned();
            $table->string('email');
            $table->integer('peer_reflection')->unsigned()->default(1);
            $table->integer('counter_sending_peer_reflection')->unsigned()->default(0);
            $table->integer('success_peer_reflection')->unsigned()->default(0);
            $table->integer('reminder_peer_reflection')->unsigned()->default(0);
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
        Schema::dropIfExists('peer_list');
    }
}
