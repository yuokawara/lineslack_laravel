<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLineFriendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_friends', function (Blueprint $table) {
            $table->id();
            $table->string('line_id', 64)->unique();
            $table->string('display_name', 64);
            $table->text('access_token');
            $table->string('refresh_token');
            $table->string('notify_token');
            $table->string('avatar')->nullable();
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
        Schema::dropIfExists('line_friends');
    }
}
