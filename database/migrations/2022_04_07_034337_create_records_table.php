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
        Schema::create('records', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description')->nullable();
            $table->unsignedInteger('lockerId');
            $table->uuid('userId');
            $table->timestamps();
            $table->foreign('userId')->references('id')->on('users');
            $table->foreign('lockerId')->references('id')->on('lockers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('records');
    }
};
