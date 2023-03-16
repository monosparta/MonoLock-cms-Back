<?php

use App\Models\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

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
            $table->uuid('uuid')->after('id')->unique()->default(DB::raw('(UUID())'));
        });

        // 塞值
        $users = User::all();
        foreach ($users as $user) {
            $user->uuid = Str::uuid();
            $user->save();
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('users', function (Blueprint $table) {
        //     $table->dropColumn('uuid');
        // });
    }
};
