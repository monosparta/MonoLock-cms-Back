<?php
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('permission')->default(1);
            $table->string('name',40);
            $table->string('password',80);
            $table->string('cardId',20)->unique()->nullable();
            $table->string('phone',20)->unique()->nullable();
            $table->string('mail',80)->unique();
            $table->dateTime('token_expire_time')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
