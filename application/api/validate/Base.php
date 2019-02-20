<?php
// +----------------------------------------------------------------------
// | TP5CMS 内容管理系统 API接口 验证 基类
// +----------------------------------------------------------------------
// | Copyright (c) 2007-2016 http://whuit.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: justin.郑 <3907721@qq.com>
// +----------------------------------------------------------------------

namespace app\api\validate;

use think\Validate;
use app\lib\exception\ParameterException;
use think\Exception;
use think\Request;

class Base extends Validate{
    public function goCheck(){
        //获取http传入的参数 对这些参数进行验证
        $request = Request::instance();
        $params  = $request->param();

        $result = $this->batch()->check($params);

        if(!$result){
            $e = new ParameterException(
                [
                    'msg' => $this->error
                ]
            );
            throw $e;
        }else{
            return true;
        }
    }

    //必须是正整数
    protected function isPositiveInteger($value, $rule = '', $data = '', $field = ''){
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0){
            return true;
        }else{
            return false;
        }
    }

    //手机号验证
    protected function isMobile($value){
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    //是否为空验证
    protected function isNotEmpty($value, $rule = '', $data = '', $field = ''){
        if (empty($value)){
            return false;
        }else{
            return true;
        }
    }
}
