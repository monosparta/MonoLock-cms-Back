<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        // 刪除資料表中的舊關聯
        Schema::table('lockers', function (Blueprint $table) {
            $table->dropForeign(['userId']);
        });

        // 修改欄位型態為uuid和修改參考欄位
        Schema::table('lockers', function (Blueprint $table) {
            $table->uuid('userId')->change();
        });

        Schema::table('lockers', function (Blueprint $table) {
            DB::statement(
                'UPDATE lockers INNER JOIN users ON lockers.userId = users.id 
                    SET lockers.userId = users.uuid 
                    WHERE lockers.userId = users.id'
            );
        });

        Schema::table('lockers', function (Blueprint $table) {
            $table->foreign('userId')->references('uuid')->on('users');
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
