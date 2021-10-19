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
        DB::insert("INSERT INTO `sys_user` (`id`, `username`, `nickname`, `password`, `salt`, `avatar`, `birthday`, `gender`, `email`, `phone`, `status`, `identity`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES (1, 'admin', '管理员', '00f8b5ecaeb2e971ac2d1e4cd6a83a09', 'ZzypRB', NULL, NULL, 0, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL)");
        DB::insert("INSERT INTO `sys_user` (`id`, `username`, `nickname`, `password`, `salt`, `avatar`, `birthday`, `gender`, `email`, `phone`, `status`, `identity`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES (2, '李威', '李威', '22f06496a071081240eab163c8655ff7', 'Sc1ePB', NULL, NULL, 0, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL)");
        DB::insert("INSERT INTO `sys_user` (`id`, `username`, `nickname`, `password`, `salt`, `avatar`, `birthday`, `gender`, `email`, `phone`, `status`, `identity`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES (3, '赵丽红', '赵丽红', 'cb38b136ac77796bd9f3a91162ce4037', '4kkMwx', NULL, NULL, 0, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL)");
    }
}
