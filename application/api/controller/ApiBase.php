<?php
// +----------------------------------------------------------------------
// | TP5CMS 内容管理系统 接口  安全加密 sign 基类
// +----------------------------------------------------------------------
// | Copyright (c) 2007-2016 http://whuit.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: justin.郑 <3907721@qq.com>
// +----------------------------------------------------------------------
namespace app\api\controller;
use think\Controller;
use app\lib\exception\BaseException;
use app\lib\exception\SignException;
use app\lib\Aes;
use app\lib\IAuth;
use think\Cache;

class ApiBase extends Controller{
    /**
     * 初始化方法
     */
    public function _initialize(){
        $this->checkRequestAuth();
        //$this->testAes();
    }

    //检查每次请求的数据是否合法
    public function checkRequestAuth(){
        //首先获取headers
        $headers = request()->header();

        if(empty($headers['sign'])){
            throw new SignException();
        }

        if(!IAuth::checkSignPass($headers)){
            throw new BaseException([
                'code' => 401,
                'message' => '授权码Sign失败',
                'errorCode' => 4000
            ]);
        };

        Cache::set($headers['sign'],1,config('api.app_sign_cache_time'));
    }

    public function testAes(){
        // $str = "id=233&name=justin&age=32";
        // echo (new Aes())->encrypt($str);exit();

        $data = [
            'sign'  => 'gsdata123456',
            'version' => 'v1',
            // 'time'    => $this->get13TimeStamp(),
        ];
        $data = IAuth::setSign($data);
        dump($data);
        //echo (new Aes())->encrypt($data);exit();
        // $str = "XHPZRdcOot4H1BWNxXs336Fk9XYvDb/PyDaM2R0RnB0=";
        // echo (new Aes())->decrypt($str);exit();
    }

    //设置13位时间戳
    public function get13TimeStamp() {
        list($t1, $t2) = explode(' ', microtime());
        return $t2 . ceil($t1 * 1000);
    }
}
