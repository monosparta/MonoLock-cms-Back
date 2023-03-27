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
        Schema::dropIfExists('records');
        Schema::dropIfExists('lockers');
        Schema::dropIfExists('users');
        Schema::rename('temp_records', 'records');
        Schema::rename('temp_lockers', 'lockers');
        Schema::rename('temp_users', 'users');
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
