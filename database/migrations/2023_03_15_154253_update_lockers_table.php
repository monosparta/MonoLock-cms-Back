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
            if (env('DB_CONNECTION') === 'mysql') {
                $table->dropForeign(['userId']);
            }
        });

        // 修改欄位型態為uuid格式
        Schema::table('lockers', function (Blueprint $table) {
            $table->uuid('userId')->change();
        });

        // 更新原userId流水號為uuid字串
        if (env('DB_CONNECTION') !== 'sqlite') {
            DB::statement(
                'UPDATE lockers INNER JOIN users ON lockers.userId = users.id 
                    SET lockers.userId = users.uuid 
                    WHERE lockers.userId = users.id'
            );
        }
        else {
            DB::statement(
                'UPDATE lockers JOIN users ON lockers.userId = users.id 
                    SET lockers.userId = users.uuid 
                    WHERE lockers.userId = users.id'
            );    
        }
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
