<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSysActivity extends Migration
{
    /**
     * Run the migrations.
     * 创建活动表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_activity', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('主键id');
            $table->string('act_name', 100)->unique()->comment('活动名称');
            $table->longText('act_desc')->nullable()->comment('活动描述');
            $table->date('act_start')->nullable()->comment('活动开始');
            $table->date('act_end')->nullable()->comment('活动结束');
            $table->string('act_type', 20)->nullable()->comment('活动类型');
            $table->double('budget', 8, 4)->nullable()->comment('预算');
            $table->tinyInteger('status')->default(1)->nullable()->comment('状态 1正常2冻结');
            $table->integer('create_by')->nullable()->comment('创建人id');
            $table->integer('update_by')->nullable()->comment('更新人id');
            $table->string('remark', 500)->nullable()->comment('备注');
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
        Schema::dropIfExists('sys_activity');
    }
}
