<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create user server table migrations.
 * 生成用户服务表迁移文件
 */
class CreateUserServersTable extends Migration
{
    /**
     * Run the migrations to create user servers table.
     * 生成用户服务表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_servers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('server_id');
            $table->bigInteger('user_id');
            $table->string('server_name');
            $table->string('server_status');
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
        Schema::dropIfExists('user_servers');
    }
}
