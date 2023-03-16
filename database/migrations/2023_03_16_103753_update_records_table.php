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
        // Schema::table('records', function (Blueprint $table) {
            // if (env('DB_CONNECTION') !== 'sqlite') {
            // $table->foreign('userId')->references('id')->on('users')->nullOnDelete();
            // }
        // });
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
};
