<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSysUser extends Migration
{
    /**
     * Run the migrations.
     * 创建迁移: php artisan make:migration create_table_sys_user
     * 执行迁移: php artisan migrate
     * 建表参考地址: 
     * https://learnku.com/docs/laravel/5.4/migrations/1261#creating-tables
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('主键id');
            $table->string('username', 100)->unique()->comment('登录账户');
            $table->string('nickname', 100)->nullable()->comment('昵称');
            $table->string('password', 100)->nullable()->comment('密码 md5(u_s_p)');
            $table->string('salt', 20)->nullable()->comment('盐');
            $table->string('avatar', 256)->nullable()->comment('头像');
            $table->date('birthday')->nullable()->comment('生日');
            $table->tinyInteger('gender')->default(0)->nullable()->comment('性别 0未知1男2女');
            $table->string('email', 100)->nullable()->comment('邮箱');
            $table->string('phone', 20)->nullable()->comment('手机');
            $table->tinyInteger('status')->default(1)->nullable()->comment('状态 1正常2冻结');
            $table->tinyInteger('identity')->nullable()->comment('身份 1超级管理员 2游客');
            $table->rememberToken();
            $table->nullableTimestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_user');
    }
}
