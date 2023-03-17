<?php

use App\Models\Record;
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
        Schema::create('temp_records', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description')->nullable();
            $table->unsignedInteger('lockerId');
            $table->uuid('userId');
            $table->timestamps();
        });

        $records = Record::orderBy('id', 'ASC')->get();
        foreach ($records as $record) {
            $result = DB::select(
                'SELECT temp_users.id as newUuid FROM `records` 
                INNER JOIN users on users.id = records.userId
                INNER JOIN temp_users on temp_users.mail = users.mail
                WHERE users.id = ?;',
                [$record->userId]
            );
            DB::statement(
                'INSERT INTO temp_records (description, lockerId, userId)
                        VALUES (:description, :lockerId, :userId);',
                [
                    $record->description,
                    $record->lockerId,
                    $result[0]->newUuid,
                ]
            );
        }
        Schema::table('temp_records', function (Blueprint $table) {
            $table->foreign('userId')->references('id')->on('temp_users');
            $table->foreign('lockerId')->references('id')->on('temp_lockers');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('temp_records', function (Blueprint $table) {
        //     $table->dropForeign(['userId']);
        // });
        Schema::dropIfExists('temp_records');
    }
};
