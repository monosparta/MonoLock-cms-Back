<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_lockers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lockerNo', 20)->unique()->nullable();
            $table->string('lockerEncoding', 4)->unique()->nullable();
            $table->boolean('lockUp')->default(true);
            $table->uuid('userId');
            $table->boolean('error')->default(false);
            $table->timestamps();
            $table->foreign('userId')->references('id')->on('temp_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_lockers');
    }
};
