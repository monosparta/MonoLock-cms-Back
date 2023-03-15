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
        Schema::table('records', function (Blueprint $table) {
            $table->dropForeign(['userId']);
        });

        // 修改欄位型態為uuid和修改參考欄位
        Schema::table('records', function (Blueprint $table) {
            $table->uuid('userId')->change();
            $table->forein('userId')->references('uuid')->on('users');
        });

        DB::statement(
            'UPDATE records INNER JOIN users ON records.userId = users.id 
                SET records.userId = users.uuid 
                WHERE records.userId = users.id'
        );

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
