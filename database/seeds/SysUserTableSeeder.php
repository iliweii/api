<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SysUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 创建Seeder: php artisan make:seeder SysUserTableSeeder
     * 运行Seeder: php artisan db:seed --class=SysUserTableSeeder
     * 查询构造器：
     * https://learnku.com/docs/laravel/5.4/queries/1259
     * 找不到类解决办法：composer dumpautoload
     *
     * @return void
     */
    public function run()
    {
        DB::insert("INSERT INTO `sys_user` (`id`, `username`, `nickname`, `password`, `salt`, `avatar`, `birthday`, `gender`, `email`, `phone`, `status`, `identity`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES (1, 'admin', '管理员', 'a2661cfed1dffee1', 'ZzypRB', NULL, NULL, 0, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL)");
        DB::insert("INSERT INTO `sys_user` (`id`, `username`, `nickname`, `password`, `salt`, `avatar`, `birthday`, `gender`, `email`, `phone`, `status`, `identity`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES (2, '李威', '李威', '40509a8c05fd411a', 'Sc1ePB', NULL, NULL, 0, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL)");
        DB::insert("INSERT INTO `sys_user` (`id`, `username`, `nickname`, `password`, `salt`, `avatar`, `birthday`, `gender`, `email`, `phone`, `status`, `identity`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES (3, '赵丽红', '赵丽红', '36b71aa1564a76ef', '4kkMwx', NULL, NULL, 0, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL)");
    }
}
