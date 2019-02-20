<?php
// +----------------------------------------------------------------------
// | TP5CMS 内容管理系统 微信模块
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.gsdata.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: justin.郑 <3907721@qq.com>
// +----------------------------------------------------------------------

namespace app\wx\controller;
use think\Controller;

class Index extends Controller{
    public function index(){
        return $this->fetch();
    }
}
