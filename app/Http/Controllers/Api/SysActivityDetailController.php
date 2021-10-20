<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

use Illuminate\Support\Facades\DB;

/**
 * @Resource("SysActivityDetail")
 */
class SysActivityDetailController extends Controller
{

    // 活动明细状态
    const DETAIL_STATUS_NORMAL = 1; // 正常
    const DETAIL_STATUS_FREEZE = 2; // 冻结

    // 购买状态
    const BUY_STS_NONE = 1; // 未购买
    const BUY_STS_DONE = 2; // 已购买

    // 审核状态
    const REVIEW_STS_NONE = 1; // 未审核
    const REVIEW_STS_DONE = 2; // 已审核
    const REVIEW_BY = 1; // 默认由管理员审核通过

    /**
     * 活动明细列表
     * @return response
     */
    public function list()
    {
        // 获取活动明细
        $activity = DB::table('sys_activity_detail')->get();
        // 预设返回状态
        $this->returned['result']['code'] = 200;
        $this->returned['result']['status'] = 'ok';
        $this->returned['result']['msg'] = '查询列表数据成功';
        $this->returned['data'] = $activity;
        // 返回结果
        return response()->json($this->returned);
    }

    /**
     * 活动明细列表查询
     * @return response
     */
    public function listPage($act_id)
    {
        // 参数检验
        $this->returned['result']['code'] = 200;
        if ($act_id == null || $act_id == '') {
            $this->returned['result']['status'] = 'warning';
            $this->returned['result']['msg'] = '必传参数不能为空';
            return response()->json($this->returned);
        }
        // 查询活动并校验
        $activity = DB::table('sys_activity')->where('id', $act_id)->first();
        if ($activity == null) {
            $this->returned['result']['status'] = 'warning';
            $this->returned['result']['msg'] = '活动不存在！';
            return response()->json($this->returned);
        }
        // 获取活动明细
        $detail = DB::table('sys_activity_detail')
            ->where([
                ['act_id', '=', $act_id],
                ['status', '=', self::DETAIL_STATUS_NORMAL],
            ])
            ->orderBy('created_at', 'desc')
            ->get();
        // 预设返回状态
        $this->returned['result']['code'] = 200;
        $this->returned['result']['status'] = 'ok';
        $this->returned['result']['msg'] = '查询列表数据成功';
        $this->returned['data'] = $detail;
        // 返回结果
        return response()->json($this->returned);
    }

    /**
     * 新增活动明细
     * @param Request
     * @return response
     */
    public function add(Request $Request)
    {
        // 接收参数
        $act_id = $Request->input('act_id');
        // 校验 预设返回状态
        $this->returned['result']['code'] = 200;
        if ($act_id == null || $act_id == '') {
            $this->returned['result']['status'] = 'warning';
            $this->returned['result']['msg'] = '必传参数不能为空';
            return response()->json($this->returned);
        }
        // 查询活动并校验
        $activity = DB::table('sys_activity')->where('id', $act_id)->first();
        if ($activity == null) {
            $this->returned['result']['status'] = 'warning';
            $this->returned['result']['msg'] = '活动不存在！';
            return response()->json($this->returned);
        }
        $name = $Request->input('name');
        $desc = $Request->input('desc');
        $url = $Request->input('url');
        $images = $Request->input('images');
        $type = $Request->input('type');
        $budget = $Request->input('budget');
        $number = $Request->input('number');
        $cost = $Request->input('cost');
        $buy_at = $Request->input('buy_at');
        $weight = $Request->input('weight');
        $reason = $Request->input('reason');
        $remark = $Request->input('remark');
        $buy_sts = $Request->input('buy_sts');
        $review_sts = self::REVIEW_STS_DONE;
        $review_by = self::REVIEW_BY;
        $create_by = $Request->input('create_by');
        // 新增用户DB
        $id = DB::table('sys_activity_detail')->insertGetId([
            'act_id' => $act_id,
            'name' => $name,
            'desc' => $desc,
            'url' => $url,
            'images' => $images,
            'type' => $type,
            'budget' => $budget,
            'number' => $number,
            'cost' => $cost,
            'buy_at' => $buy_at,
            'weight' => $weight,
            'reason' => $reason,
            'remark' => $remark,
            'buy_sts' => $buy_sts,
            'review_sts' => $review_sts,
            'review_by' => $review_by,
            'create_by' => $create_by,
        ]);
        // 预设返回状态
        $this->returned['result']['code'] = 200;
        if ($id) {
            $this->returned['result']['status'] = 'ok';
            $this->returned['result']['msg'] = '新增活动明细成功';
            $this->returned['data'] = $id;
        } else {
            $this->returned['result']['status'] = 'error';
            $this->returned['result']['msg'] = '新增活动明细失败';
        }
        // 返回结果
        return response()->json($this->returned);
    }

    /**
     * 修改活动明细
     * @param Request
     * @return response
     */
    public function edit(Request $Request)
    {
        // 接收参数
        $id = $Request->input('id');
        $name = $Request->input('name');
        $desc = $Request->input('desc');
        $url = $Request->input('url');
        $images = $Request->input('images');
        $type = $Request->input('type');
        $budget = $Request->input('budget');
        $number = $Request->input('number');
        $cost = $Request->input('cost');
        $buy_at = $Request->input('buy_at');
        $weight = $Request->input('weight');
        $reason = $Request->input('reason');
        $remark = $Request->input('remark');
        $buy_sts = $Request->input('buy_sts');
        $update_by = $Request->input('update_by');
        // 获取活动明细
        $detail = DB::table('sys_activity_detail')->where('id', $id)->first();
        if ($detail == null) {
            // 活动明细不存在
            $this->returned['result']['code'] = 200;
            $this->returned['result']['status'] = 'error';
            $this->returned['result']['msg'] = '活动明细不存在';
            return response()->json($this->returned);
        }
        // 初始化参数
        $name = $name == null ? $detail->name : $name;
        $desc = $desc == null ? $detail->desc : $desc;
        $url = $url == null ? $detail->url : $url;
        $images = $images == null ? $detail->images : $images;
        $type = $type == null ? $detail->type : $type;
        $budget = $budget == null ? $detail->budget : $budget;
        $number = $number == null ? $detail->number : $number;
        $cost = $cost == null ? $detail->cost : $cost;
        $buy_at = $buy_at == null ? $detail->buy_at : $buy_at;
        $weight = $weight == null ? $detail->weight : $weight;
        $reason = $reason == null ? $detail->reason : $reason;
        $remark = $remark == null ? $detail->remark : $remark;
        $buy_sts = $buy_sts == null ? $detail->buy_sts : $buy_sts;
        $update_by = $update_by == null ? $detail->update_by : $update_by;

        // 执行修改活动DB
        DB::table('sys_activity')
            ->where('id', $id)
            ->update([
                'name' => $name,
                'desc' => $desc,
                'url' => $url,
                'images' => $images,
                'type' => $type,
                'budget' => $budget,
                'number' => $number,
                'cost' => $cost,
                'buy_at' => $buy_at,
                'weight' => $weight,
                'reason' => $reason,
                'remark' => $remark,
                'buy_sts' => $buy_sts,
                'update_by' => $update_by,
            ]);
        // 预设返回状态
        $this->returned['result']['code'] = 200;
        $this->returned['result']['status'] = 'ok';
        $this->returned['result']['msg'] = '修改活动明细信息成功';
        $this->returned['data'] = $id;
        // 返回结果
        return response()->json($this->returned);
    }

    /**
     * 通过id删除活动明细
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
            // 删除活动明细
            DB::table('sys_activity_detail')->where('id', $id)->delete();
            $this->returned['result']['status'] = 'ok';
            $this->returned['result']['msg'] = '活动明细删除成功';
        }
        // 返回结果
        return response()->json($this->returned);
    }

    /**
     * 通过id查询活动明细
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
            // 获取活动明细
            $activity = DB::table('sys_activity_detail')
                ->where('id', $id)
                ->first();
            // 活动明细存在的情况
            if ($activity != null) {
                $this->returned['result']['status'] = 'ok';
                $this->returned['result']['msg'] = '查询活动明细数据成功';
                $this->returned['data'] = $activity;
            } else {
                // 活动明细不存在
                $this->returned['result']['status'] = 'warning';
                $this->returned['result']['msg'] = '活动明细不存在';
            }
        }
        // 返回结果
        return response()->json($this->returned);
    }
}
