<?php
// +----------------------------------------------------------------------
// | TP5CMS 内容管理系统 后台管理 单元类
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.gsdata.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: justin.郑 <3907721@qq.com>
// +----------------------------------------------------------------------

namespace app\index\controller;
use think\Controller;
use app\index\model\Daily as DailyModel;

class Index extends Controller{
    public function index(){
        // $res = UserModel::all();
        // dump($res);
        // return $this->redirect('admin/Index/index');
        return $this->fetch();
    }

    public function cs(){
        $res = DailyModel::all();
        dump($res);
    }
}
