<?php
// +----------------------------------------------------------------------
// | TP5CMS 内容管理系统 后台管理 公共类
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.gsdata.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: justin.郑 <3907721@qq.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;
use app\admin\controller\Base;

class Index extends Base{
    public function index(){
        return $this->fetch();
    }

    public function welcome(){
    	return $this->fetch();
    }
}