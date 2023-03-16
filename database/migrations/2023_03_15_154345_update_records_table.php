<?php

use App\Models\Record;
use App\Models\User;
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
            if (env('DB_CONNECTION') === 'mysql') {
                $table->dropForeign(['userId']);
            }
        });

        // 修改欄位型態為uuid格式
        Schema::table('records', function (Blueprint $table) {
            $table->uuid('userId')->change();
        });

        // 更新原userId流水號為uuid字串
        $users = User::all()->toArray();
        $records = Record::all();
        foreach ($records as $record) {
            $index = random_int(0, count($users) - 1);
            $record->update([
                'userId'=> $users[$index]['uuid'],
            ]);
            array_splice($users, $index, 1);
        }

        // 建立新關聯
        Schema::table('records', function (Blueprint $table) {
            $table->foreign('userId')->references('uuid')->on('users')->nullOnDelete();
        });

        // DB::statement(
        //     'UPDATE records INNER JOIN users ON records.userId = users.id 
        //             SET records.userId = users.uuid 
        //             WHERE records.userId = users.id'
        // );

        // if (env('DB_CONNECTION') !== 'sqlite') {
        //     DB::statement(
        //         'UPDATE records INNER JOIN users ON records.userId = users.id 
        //             SET records.userId = users.uuid 
        //             WHERE records.userId = users.id'
        //     );
        // } else {
        //     DB::statement(
        //         'UPDATE records JOIN users ON records.userId = users.id 
        //             SET records.userId = users.uuid 
        //             WHERE records.userId = users.id'
        //     );
        // }
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
