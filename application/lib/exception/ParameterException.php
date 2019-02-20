<?php
// +----------------------------------------------------------------------
// | TP5CMS 内容管理系统 异常处理类 验证类
// +----------------------------------------------------------------------
// | Copyright (c) 2007-2016 http://whuit.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: justin.郑 <3907721@qq.com>
// +----------------------------------------------------------------------
namespace app\lib\exception;
use app\lib\exception\BaseException;

class ParameterException extends BaseException{
    public $code = 400;
    public $message = '参数错误';
    public $errorCode = 10000;
}
