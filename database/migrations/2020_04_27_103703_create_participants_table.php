<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('company_id')->unsigned();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->integer('self_reflection')->unsigned()->default(1);
            $table->integer('counter_sending_self_reflection')->unsigned()->default(0);
            $table->integer('success_self_reflection')->unsigned()->default(0);
            $table->integer('reminder_self_reflection')->unsigned()->default(0);
            $table->integer('peer_reflection')->unsigned()->default(1);
            $table->integer('counter_sending_peer_reflection')->unsigned()->default(0);
            $table->integer('success_peer_reflection')->unsigned()->default(0);
            $table->integer('reminder_peer_reflection')->unsigned()->default(0);
            $table->integer('status_peer_list')->unsigned()->default(0);
            //$table->string('peer_collection')->default('test');
            $table->timestamps();
            $table->index('first_name');
            $table->index('last_name');
            $table->index('email');
        });

        Schema::table('participants', function (Blueprint $table) {
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participants');
    }
}
