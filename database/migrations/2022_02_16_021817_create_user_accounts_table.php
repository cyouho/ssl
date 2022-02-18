<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create user account table migrations.
 * 生成用户账户表迁移文件
 */
class CreateUserAccountsTable extends Migration
{
    /**
     * Run the migrations to create user account table.
     * 生成用户账户表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_accounts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('user_id');
            $table->string('user_name');
            $table->string('user_email');
            $table->string('user_password');
            $table->string('user_token');
            $table->timestamps();
            $table->timestamp('last_login_at');
            $table->bigInteger('total_login_times');
        });
    }

    /**
     * Reverse the migrations to drop user account table.
     * 删除用户账户表
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_accounts');
    }
}
