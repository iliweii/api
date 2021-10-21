<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

use Illuminate\Support\Facades\DB;

/**
 * @Resource("SysActivity")
 */
class SysActivityController extends Controller
{

    // 活动状态
    const ACTIVITY_STATUS_NORMAL = 1; // 正常
    const ACTIVITY_STATUS_FREEZE = 2; // 冻结

    // 活动类型
    const ACTIVITY_TYPE_1 = "shoping_list"; // 购物清单
    const ACTIVITY_TYPE_2 = "to_do"; // 待办事项
    const ACTIVITY_TYPE_3 = "countdown"; // 倒计时
    const ACTIVITY_TYPE_3A = "countdown_chsi"; // 考研倒计时

    // 购买状态
    const BUY_STS_NONE = 1; // 未购买
    const BUY_STS_DONE = 2; // 已购买

    /**
     * 活动列表
     * @return response
     */
    public function list()
    {
        // 获取活动
        $activity = DB::table('sys_activity')->get();
        // 预设返回状态
        $this->returned['result']['code'] = 200;
        $this->returned['result']['status'] = 'ok';
        $this->returned['result']['msg'] = '查询列表数据成功';
        $this->returned['data'] = $activity;
        // 返回结果
        return response()->json($this->returned);
    }

    /**
     * 活动列表查询
     * @return response
     */
    public function listPage()
    {
        // 获取活动
        $activity = DB::table('sys_activity')
            ->where([
                ['act_start', '<=', date("Y-m-d")],
                ['act_end', '>=', date("Y-m-d")],
                ['status', '=', self::ACTIVITY_STATUS_NORMAL],
            ])
            ->orderBy('created_at', 'desc')
            ->get();
        foreach ($activity as $act) {
            $detail = DB::table('sys_activity_detail')
                ->where('act_id', $act->id)->get();
            $budget_use = 0;
            $cost_total = 0;
            $buyed_num = 0;
            $total_num = count($detail);
            foreach ($detail as $d) {
                $budget_use += $d->budget;
                $cost_total += $d->cost;
                if ($d->buy_sts == self::BUY_STS_DONE) $buyed_num++;
            }
            $act->budget_use = $budget_use;
            $act->cost_total = $cost_total;
            $act->buyed_num = $buyed_num;
            $act->total_num = $total_num;
        }
        // 预设返回状态
        $this->returned['result']['code'] = 200;
        $this->returned['result']['status'] = 'ok';
        $this->returned['result']['msg'] = '查询列表数据成功';
        $this->returned['data'] = $activity;
        // 返回结果
        return response()->json($this->returned);
    }

    /**
     * 新增活动
     * @param Request
     * @return response
     */
    public function add(Request $Request)
    {
        // 接收参数
        $act_name = $Request->input('act_name');
        $act_desc = $Request->input('act_desc');
        $act_start = $Request->input('act_start');
        $act_end = $Request->input('act_end');
        $budget = $Request->input('budget');
        $create_by = $Request->input('create_by');
        $remark = $Request->input('remark');
        // 新增活动DB
        $id = DB::table('sys_activity')->insertGetId([
            'act_name' => $act_name,
            'act_desc' => $act_desc,
            'act_start' => $act_start,
            'act_end' => $act_end,
            'budget' => $budget,
            'create_by' => $create_by,
            'remark' => $remark,
        ]);
        // 预设返回状态
        $this->returned['result']['code'] = 200;
        if ($id) {
            $this->returned['result']['status'] = 'ok';
            $this->returned['result']['msg'] = '新增活动成功';
            $this->returned['data'] = $id;
        } else {
            $this->returned['result']['status'] = 'error';
            $this->returned['result']['msg'] = '新增活动失败';
        }
        // 返回结果
        return response()->json($this->returned);
    }

    /**
     * 修改活动
     * @param Request
     * @return response
     */
    public function edit(Request $Request)
    {
        // 接收参数
        $id = $Request->input('id');
        $act_name = $Request->input('act_name');
        $act_desc = $Request->input('act_desc');
        $act_start = $Request->input('act_start');
        $act_end = $Request->input('act_end');
        $budget = $Request->input('budget');
        $update_by = $Request->input('update_by');
        $remark = $Request->input('remark');
        // 获取活动
        $activity = DB::table('sys_activity')->where('id', $id)->first();
        if ($activity == null) {
            // 活动不存在
            $this->returned['result']['code'] = 200;
            $this->returned['result']['status'] = 'error';
            $this->returned['result']['msg'] = '活动不存在';
            return response()->json($this->returned);
        }
        // 初始化参数
        $act_name = $act_name == null ? $activity->act_name : $act_name;
        $act_desc = $act_desc == null ? $activity->act_desc : $act_desc;
        $act_start = $act_start == null ? $activity->act_start : $act_start;
        $act_end = $act_end == null ? $activity->act_end : $act_end;
        $budget = $budget == null ? $activity->budget : $budget;
        $update_by = $update_by == null ? $activity->update_by : $update_by;
        $remark = $remark == null ? $activity->remark : $remark;

        // 执行修改活动DB
        DB::table('sys_activity')
            ->where('id', $id)
            ->update([
                'act_name' => $act_name,
                'act_desc' => $act_desc,
                'act_start' => $act_start,
                'act_end' => $act_end,
                'budget' => $budget,
                'update_by' => $update_by,
                'remark' => $remark,
            ]);
        // 预设返回状态
        $this->returned['result']['code'] = 200;
        $this->returned['result']['status'] = 'ok';
        $this->returned['result']['msg'] = '修改活动信息成功';
        $this->returned['data'] = $id;
        // 返回结果
        return response()->json($this->returned);
    }

    /**
     * 通过id删除活动
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
            // 删除活动
            DB::table('sys_activity')->where('id', $id)->delete();
            $this->returned['result']['status'] = 'ok';
            $this->returned['result']['msg'] = '活动删除成功';
        }
        // 返回结果
        return response()->json($this->returned);
    }

    /**
     * 通过id查询活动
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
            // 获取活动
            $activity = DB::table('sys_activity')
                ->where('id', $id)
                ->first();
            // 活动存在的情况
            if ($activity != null) {
                $this->returned['result']['status'] = 'ok';
                $this->returned['result']['msg'] = '查询活动数据成功';
                $this->returned['data'] = $activity;
            } else {
                // 活动不存在
                $this->returned['result']['status'] = 'warning';
                $this->returned['result']['msg'] = '活动不存在';
            }
        }
        // 返回结果
        return response()->json($this->returned);
    }
}
