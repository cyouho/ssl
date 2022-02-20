<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create servers table migrations.
 * 生成服务表迁移文件
 */
class CreateServersTable extends Migration
{
    /**
     * Run the migrations to create servers table.
     * 生成服务表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->id('server_id');
            $table->string('server_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servers');
    }
}
