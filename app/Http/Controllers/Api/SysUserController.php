<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

/**
 * @Resource("SysUser")
 */
class SysUserController extends Controller
{

    public function index()
    {
        $data = DB::table('sys_user')->get();
        $this->returned['result']['code'] = 200;
        $this->returned['result']['status'] = 'success';
        $this->returned['result']['msg'] = '获取数据列表成功';
        $this->returned['data'] = $data;
        return response()->json($this->returned);
    }
}
