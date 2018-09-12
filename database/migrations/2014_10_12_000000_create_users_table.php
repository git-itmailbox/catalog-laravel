<?php

use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedSmallInteger('type');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        $user = new User();
        $user->email = 'admin@domain.com';
        $user->name = 'admin';
        $user->type = User::TYPE_ADMIN;
        $user->password = bcrypt('secret');
        $user->save();

        $simpleUser = new User();
        $simpleUser->email = 'user@domain.com';
        $simpleUser->name = 'simple user';
        $simpleUser->type = User::TYPE_SIMPLE_USER;
        $simpleUser->password = bcrypt('secret');
        $simpleUser->save();
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
}
