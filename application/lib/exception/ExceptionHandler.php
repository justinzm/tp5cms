<?php
// +----------------------------------------------------------------------
// | TP5CMS 内容管理系统 异常处理类 继承Handle类 并进行取代
// +----------------------------------------------------------------------
// | Copyright (c) 2007-2016 http://whuit.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: justin.郑 <3907721@qq.com>
// +----------------------------------------------------------------------
namespace app\lib\exception;
use think\Exception;
use think\exception\Handle;
use think\Request;

class ExceptionHandler extends Handle{
    private $code;
    private $message;
    private $errorCode;
    //需要返回客户端当前请求的URL路径

    public function render(\Exception $e){
        if($e instanceof BaseException){
            //如果是自定义的异常
            $this->code = $e->code;
            $this->message  = $e->message;
            $this->errorCode = $e->errorCode;
        }else{
            //系统异常
            if(!config('app_debug')){
                $this->code = 500;
                $this->message  = '系统内部错误';
                $this->errorCode = 999;
                $this->recordErrorLog($e);
            }else{
                return parent::render($e);
            }
        }

        $request = Request::instance();
        $result = [
            'message' => $this->message,
            'error_code' => $this->errorCode,
            'request_url'=> $request->url()
        ];
        return json($result, $this->code);
    }


    private function recordErrorLog(Exception $e){
        Log::init(
            [
                'type' => 'File',
                'path' => LOG_PATH,
                'level' => ['error']
            ]);
        Log::record($e->getMessage(), 'error');
    }
}
