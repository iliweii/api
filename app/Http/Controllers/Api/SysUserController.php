<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

use Illuminate\Support\Facades\DB;

/**
 * @Resource("SysUser")
 */
class SysUserController extends Controller
{

    // 用户状态
    const USER_STATUS_NORMAL = 1; // 正常
    const USER_STATUS_FREEZE = 2; // 冻结

    // 用户身份
    const USER_IDENTITY_1 = 1; // 超级管理员
    const USER_IDENTITY_2 = 2; // 游客

    /**
     * 登录
     * @param Request
     * @return response
     */
    public function login(Request $Request)
    {
        // 接收参数
        $username = $Request->input('username');
        $password = $Request->input('password');
        // 获取用户
        $user = $this->getUser($username);
        // 预设返回状态
        $this->returned['result']['code'] = 200;
        // 空情况
        if ($user == null) {
            // 定义空情况返回参数
            $this->returned['result']['status'] = 'warning';
            $this->returned['result']['msg'] = '用户不存在';
        } else {
            // 登录验证
            $enPassword = md5($user->username . $user->salt . $password);
            if ($user->status == 2) {
            }
            if ($enPassword == $user->password) {
                // 密码正确返回参数
                $this->returned['result']['status'] = 'ok';
                $this->returned['result']['msg'] = '登录成功';
                $this->returned['data'] = $user;
            } else {
                // 登录失败返回参数
                $this->returned['result']['status'] = 'error';
                $this->returned['result']['msg'] = '密码错误，登录失败';
            }
        }
        return response()->json($this->returned);
    }

    /**
     * 用户列表
     * @param Request
     * @return response
     */
    public function list(Request $Request)
    {
        // 接收参数
        $query = $Request->input('query');
        $query = $query == null ? '' : $query;
        // 获取用户
        $user = DB::table('sys_user')
            ->where('username', 'like', '%' . $query . '%')
            ->where('nickname', 'like', '%' . $query . '%')
            ->where('status', self::USER_STATUS_NORMAL)
            ->get();
        // 预设返回状态
        $this->returned['result']['code'] = 200;
        $this->returned['result']['status'] = 'ok';
        $this->returned['result']['msg'] = '查询列表数据成功';
        $this->returned['data'] = $user;
        // 返回结果
        return response()->json($this->returned);
    }

    /**
     * 新增用户
     * @param Request
     * @return response
     */
    public function add(Request $Request)
    {
        // 接收参数
        $username = $Request->input('username');
        $password = $Request->input('password');
        if ($username == null || $password == null) {
            // 必传参数不能为空
            $this->returned['result']['code'] = 200;
            $this->returned['result']['status'] = 'warning';
            $this->returned['result']['msg'] = '必传参数不能为空';
            response()->json($this->returned);
        }
        $nickname = $Request->input('nickname');
        $nickname = $nickname == null ? $username : $nickname;
        $salt = $this->randomStr(6);
        $password = md5($username . $salt . $password);
        $avater = $Request->input('avater');
        $birthday = $Request->input('birthday');
        $gender = $Request->input('gender');
        $email = $Request->input('email');
        $phone = $Request->input('phone');
        $identity = $Request->input('identity');
        // 新增用户DB
        $id = DB::table('sys_user')->insertGetId([
            'username' => $username,
            'password' => $password,
            'nickname' => $nickname,
            'salt' => $salt,
            'avater' => $avater,
            'birthday' => $birthday,
            'gender' => $gender,
            'email' => $email,
            'phone' => $phone,
            'identity' => $identity,
        ]);
        // 预设返回状态
        $this->returned['result']['code'] = 200;
        if ($id) {
            $this->returned['result']['status'] = 'ok';
            $this->returned['result']['msg'] = '新增用户成功';
            $this->returned['data'] = $id;
        } else {
            $this->returned['result']['status'] = 'error';
            $this->returned['result']['msg'] = '新增用户失败';
        }
        // 返回结果
        return response()->json($this->returned);
    }

    /**
     * 修改用户
     * @param Request
     * @return response
     */
    public function edit(Request $Request)
    {
        // 接收参数
        $id = $Request->input('id');
        if ($id == null) {
            // 必传参数不能为空
            $this->returned['result']['code'] = 200;
            $this->returned['result']['status'] = 'warning';
            $this->returned['result']['msg'] = '必传参数不能为空';
            response()->json($this->returned);
        }
        // 获取用户
        $user = DB::table('sys_user')->where('id', $id)->get();
        if ($user == null || count($user) < 1) {
            // 用户不存在
            $this->returned['result']['code'] = 200;
            $this->returned['result']['status'] = 'error';
            $this->returned['result']['msg'] = '用户不存在';
            response()->json($this->returned);
        } else {
            $user = $user[0];
        }
        // 接收参数并初始化参数
        $username = $Request->input('username');
        $username = $username == null ? $user->username : $username;
        $password = $Request->input('password');
        $password = $password == null ? $user->password : md5($username . $user->salt . $password);
        $nickname = $Request->input('nickname');
        $nickname = $nickname == null ? $user->nickname : $nickname;
        $avater = $Request->input('avater');
        $avater = $avater == null ? $user->avater : $avater;
        $birthday = $Request->input('birthday');
        $birthday = $birthday == null ? $user->birthday : $birthday;
        $gender = $Request->input('gender');
        $gender = $gender == null ? $user->gender : $gender;
        $email = $Request->input('email');
        $email = $email == null ? $user->email : $email;
        $phone = $Request->input('phone');
        $phone = $phone == null ? $user->phone : $phone;
        $status = $Request->input('status');
        $status = $status == null ? $user->status : $status;
        $identity = $Request->input('identity');
        $identity = $identity == null ? $user->identity : $identity;
        // 执行修改用户DB
        DB::table('sys_user')
            ->where('id', $id)
            ->update([
                'username' => $username,
                'password' => $password,
                'nickname' => $nickname,
                'avater' => $avater,
                'birthday' => $birthday,
                'gender' => $gender,
                'email' => $email,
                'phone' => $phone,
                'status' => $status,
                'identity' => $identity,
            ]);
        // 预设返回状态
        $this->returned['result']['code'] = 200;
        $this->returned['result']['status'] = 'ok';
        $this->returned['result']['msg'] = '修改用户信息成功';
        $this->returned['data'] = $id;
        // 返回结果
        return response()->json($this->returned);
    }

    /**
     * 通过id删除用户
     * @param id
     * @return response
     */
    public function delete($id)
    {
        // 预设返回状态
        $this->returned['result']['code'] = 200;
        // 参数为空
        if ($id == null) {
            $this->returned['result']['status'] = 'warning';
            $this->returned['result']['msg'] = '参数不能为空';
        } else {
            // 删除用户
            DB::table('sys_user')->where('id', $id)->delete();
            $this->returned['result']['status'] = 'ok';
            $this->returned['result']['msg'] = '用户删除成功';
        }
        // 返回结果
        return response()->json($this->returned);
    }

    /**
     * 通过id查询用户
     * @param id
     * @return response
     */
    public function queryById($id)
    {
        // 预设返回状态
        $this->returned['result']['code'] = 200;
        // 参数为空
        if ($id == null) {
            $this->returned['result']['status'] = 'warning';
            $this->returned['result']['msg'] = '参数不能为空';
        } else {
            // 获取用户
            $user = DB::table('sys_user')
                ->where('id', $id)
                ->get();
            // 用户存在的情况
            if (count($user) > 0) {
                $this->returned['result']['status'] = 'ok';
                $this->returned['result']['msg'] = '查询用户数据成功';
                $this->returned['data'] = $user[0];
            } else {
                // 用户不存在
                $this->returned['result']['status'] = 'warning';
                $this->returned['result']['msg'] = '用户不存在';
            }
        }
        // 返回结果
        return response()->json($this->returned);
    }

    /**
     * 根据username / phone / email 获取用户
     * @param username
     * @return user
     */
    private function getUser($username)
    {
        // 正则表达式
        $preg_phone = '/^1[345789]\d{9}$/ims';
        $preg_email = '/^[a-zA-Z0-9]+([-_.][a-zA-Z0-9]+)*@([a-zA-Z0-9]+[-.])+([a-z]{2,5})$/ims';
        $user = null;
        // 信息匹配
        if (preg_match($preg_phone, $username)) {
            $user = DB::table('sys_user')->where('phone', $username)->get();
        } else if (preg_match($preg_email, $username)) {
            $user = DB::table('sys_user')->where('email', $username)->get();
        } else {
            $user = DB::table('sys_user')->where('username', $username)->get();
        }
        // 用户存在的情况
        if (count($user) > 0) {
            return $user[0];
        }
        return $user;
    }

    /**
     * 随机字符串
     * @param length
     * @param characters
     * @return randomString
     */
    private function randomStr($length = 32, $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        if (!is_int($length) || $length < 0) {
            return false;
        }
        $characters_length = strlen($characters) - 1;
        $string = '';
        for ($i = $length; $i > 0; $i--) {
            $string .= $characters[mt_rand(0, $characters_length)];
        }
        return $string;
    }
}
