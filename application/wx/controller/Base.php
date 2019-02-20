<?php
// +----------------------------------------------------------------------
// | TP5CMS 内容管理系统 微信管理 公共类
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.gsdata.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: justin.郑 <3907721@qq.com>
// +----------------------------------------------------------------------

namespace app\wx\controller;
use think\Controller;
use think\Request;
use think\Session;
use think\Db;
use think\Loader;
use app\admin\model\Config as ConfigModel;

class Base extends Controller{
	protected function _initialize(){
		header("Content-Type:text/html; charset=utf-8");
		parent::_initialize();
        $this->webCon();
        $this->jssdk($this->webCon()->wxappid, $this->webCon()->wxappsecret);
	}

    /**
    * 站点信息
    */
    protected function webCon(){
        $c = ConfigModel::where('id', 1)->find();
        $this->assign('confind',$c);
        return $c;
    }

    //微信js接口
    protected function jssdk($appId, $appSecret){
        Loader::import('Jssdk.Jssdk');
        $Jssdk = new \Jssdk($appId, $appSecret);

        $signPackage = $Jssdk->GetSignPackage();
        $this->assign('signPackage',$signPackage);
    }
    
}