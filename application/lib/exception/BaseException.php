<?php
// +----------------------------------------------------------------------
// | TP5CMS 内容管理系统 异常处理类 基类
// +----------------------------------------------------------------------
// | Copyright (c) 2007-2016 http://whuit.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: justin.郑 <3907721@qq.com>
// +----------------------------------------------------------------------
namespace app\lib\exception;
use think\Exception;

class BaseException extends Exception{
    //HTTP 状态码 404，200
    public $code = 400;

    //错误具体信息
    public $message = "参数错误";

    //自定义的错误码
    public $errorCode = 10000;

    public function __construct($params = []){
        if(!is_array($params)){
            return ;
        }
        if(array_key_exists('code', $params)){
            $this->code = $params['code'];
        }
        if(array_key_exists('message', $params)){
            $this->message = $params['message'];
        }
        if(array_key_exists('errorCode', $params)){
            $this->errorCode = $params['errorCode'];
        }
    }
}
