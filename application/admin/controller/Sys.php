<?php
// +----------------------------------------------------------------------
// | TP5CMS 内容管理系统 后台管理 
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.gsdata.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: justin.郑 <3907721@qq.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;
use think\Controller;

class Sys extends Controller{
    //清除缓存
    public function cleanCache(){
        delFile('./runtime');
        return showApiJson(200,'缓存清除成功');
        exit();
    }
}