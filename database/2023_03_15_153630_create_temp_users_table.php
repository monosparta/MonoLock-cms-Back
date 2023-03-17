<?php

use App\Models\User;
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
        Schema::create('temp_users', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->integer('permission')->default(1);
            $table->string('name', 40)->nullable();
            $table->string('password', 80)->nullable();
            $table->string('cardId', 20)->unique()->nullable();
            $table->string('phone', 20)->unique()->nullable();
            $table->string('mail', 80)->unique();
            $table->dateTime('token_expire_time')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        $users = User::orderBy('id', 'DESC')->get()->toArray();
        foreach ($users as $user) {
            DB::statement(
                'INSERT INTO table_name VALUES (:permission, :name, :password, :cardId,
                    :phone, :mail, :token_expire_time, :rememberToken, :timestamps);'
                ,[$user]
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
        Schema::dropIfExists('temp_users');
    }
};
