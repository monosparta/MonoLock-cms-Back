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
        // 刪除舊的主鍵
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('id');
        });

        // 將uuid欄位設為主鍵 並改名為id
        Schema::table('users', function (Blueprint $table) {
            $table->primary('uuid');
            $table->renameColumn('uuid', 'id');
        });
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
