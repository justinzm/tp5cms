<?php
// +----------------------------------------------------------------------
// | TP5CMS 内容管理系统 异常处理类 Sign 不存在 类
// +----------------------------------------------------------------------
// | Copyright (c) 2007-2016 http://whuit.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: justin.郑 <3907721@qq.com>
// +----------------------------------------------------------------------
namespace app\lib\exception;
use app\lib\exception\BaseException;

class SignException extends BaseException{
    public $code = 401;
    public $message = 'Sign不存在';
    public $errorCode = 40000;
}
