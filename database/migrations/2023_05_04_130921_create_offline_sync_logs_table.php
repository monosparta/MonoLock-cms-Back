<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('offline_sync_logs', function (Blueprint $table) {
            $table->id();
            $table->string('mode', 10);
            $table->boolean('error')->nullable()->default(null);
            $table->foreignUuid('userId')->nullable();
            $table->foreign('userId')->references('id')->on('users')->nullOnDelete();
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
        Schema::dropIfExists('offline_sync_logs');
    }
};
