<?php

namespace App\Http\Controllers\Api;

use Dingo\Api\Http\FormRequest;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    use Helpers;

    // 预定义response数组、状态码(格式设定)
    protected $statusCode = 200;
    protected $returned = [
        'result' => [
            'code' => 0,
            'status' => 'error',
            'msg' => null
        ],
        'data' => null
    ];
}
