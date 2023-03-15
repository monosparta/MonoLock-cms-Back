<?php

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
// use UseUuid;

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
            $table->uuid('uuid')->after('id')->default(Uuid::uuid4()->toString());
        });

        // 更新uuid欄位
        Schema::table('users', function (Blueprint $table) {
            DB::statement('UPDATE users SET uuid = UUID()');
        });

        // 刪除其他資料表中的關聯
        Schema::table('lockers', function (Blueprint $table) {
            $table->dropForeign(['userId']);
        });
        Schema::table('records', function (Blueprint $table) {
            $table->dropForeign(['userId']);
        });

        // 刪除舊的自增長整數的主鍵
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
