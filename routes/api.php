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
    $api->post('user/list', 'SysUserController@list'); // 列表
    $api->post('user/queryById/{id}', 'SysUserController@queryById'); // 通过id查询


});
