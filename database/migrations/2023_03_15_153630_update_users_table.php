<?php

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use UseUuid;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 新增uuid欄位
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('uuid')->after('id');
        });

        // // 刪除舊的自增長整數的主鍵
        // Schema::table('users', function (Blueprint $table) {
        //     $table->dropColumn('id');
        // });

        // // 將uuid欄位設為主鍵 並改名為id
        // Schema::table('users', function (Blueprint $table) {
        //     $table->primary('uuid');
        //     $table->renameColumn('uuid', 'id');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
