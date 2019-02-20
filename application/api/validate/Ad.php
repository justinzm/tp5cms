<?php
// +----------------------------------------------------------------------
// | TP5CMS 内容管理系统 API接口 验证 Banner类
// +----------------------------------------------------------------------
// | Copyright (c) 2007-2016 http://whuit.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: justin.郑 <3907721@qq.com>
// +----------------------------------------------------------------------

namespace app\api\validate;

use think\Validate;
use app\api\validate\Base;

class Ad extends Base{
    protected $rule = [
        'id' => 'require|isPositiveInteger',
        'num' => 'in:1,2,4'
    ];

    protected $message=[
        'id' => 'id必须是正整数',
        'num'=> '不在范围内'
    ];
}
