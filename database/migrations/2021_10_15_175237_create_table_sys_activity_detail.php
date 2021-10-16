<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSysActivityDetail extends Migration
{
    /**
     * Run the migrations.
     * 创建活动明细表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_activity_detail', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('主键id');
            $table->integer('act_id')->nullable()->comment('活动id');
            $table->string('name', 100)->nullable()->comment('明细名称');
            $table->longText('desc')->nullable()->comment('明细描述');
            $table->string('url', 500)->nullable()->comment('明细链接');
            $table->string('images', 500)->nullable()->comment('明细图片');
            $table->string('type', 100)->nullable()->comment('明细标签');
            $table->double('budget', 8, 4)->nullable()->comment('预算');
            $table->double('number', 8, 4)->nullable()->comment('数量');
            $table->double('cost', 8, 4)->nullable()->comment('花销');
            $table->datetime('buy_at')->nullable()->comment('购买时间');
            $table->double('weight', 8, 4)->nullable()->comment('权重');
            $table->longText('reason')->nullable()->comment('原因');
            $table->string('remark', 500)->nullable()->comment('备注');
            $table->tinyInteger('status')->default(1)->nullable()->comment('状态 1正常2冻结');
            $table->tinyInteger('buy_sts')->default(1)->nullable()->comment('购买状态 1未2已');
            $table->tinyInteger('review_sts')->default(0)->nullable()->comment('审核状态 0未1已');
            $table->integer('create_by')->nullable()->comment('创建人id');
            $table->integer('update_by')->nullable()->comment('更新人id');
            $table->integer('review_by')->nullable()->comment('更新人id');
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
        Schema::dropIfExists('sys_activity_detail');
    }
}
