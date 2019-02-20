<?php
// +----------------------------------------------------------------------
// | TP5CMS 内容管理系统 异常处理类 banner 不存在 类
// +----------------------------------------------------------------------
// | Copyright (c) 2007-2016 http://whuit.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: justin.郑 <3907721@qq.com>
// +----------------------------------------------------------------------
namespace app\lib\exception;
use app\lib\exception\BaseException;

class AdMissException extends BaseException{
    public $code = 404;
    public $message = '请求的Ad不存在';
    public $errorCode = 40000;
}
