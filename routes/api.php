<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => ['bindings', 'cors'], //添加这个中间件才能使用模型绑定
], function ($api) {

    // sys_user 用户表
    $api->post('login', 'SysUserController@login'); // 登录
    $api->get('user/list', 'SysUserController@list'); // 列表
    $api->get('user/update', 'SysUserController@update'); // 修改
    $api->get('user/queryById/{id}', 'SysUserController@queryById'); // 通过id查询

    // sys_activity 活动表
    $api->get('activity/list', 'SysActivityController@listPage'); // 列表
    $api->post('activity/add', 'SysActivityController@add'); // 新增
    $api->put('activity/update', 'SysActivityController@update'); // 修改
    $api->delete('activity/delete/{id}', 'SysActivityController@delete'); // 删除
    $api->get('activity/queryById/{id}', 'SysActivityController@queryById'); // 通过id查询

    // sys_activity_detail 活动明细表
    $api->get('activity/detail/list/{id}', 'SysActivityDetailController@listPage'); // 列表
    $api->get('activity/detail/add', 'SysActivityDetailController@add'); // 新增 临时用get
    $api->put('activity/detail/update', 'SysActivityDetailController@update'); // 修改
    $api->delete('activity/detail/delete/{id}', 'SysActivityDetailController@delete'); // 删除
    $api->get('activity/detail/queryById/{id}', 'SysActivityDetailController@queryById'); // 通过id查询


});
