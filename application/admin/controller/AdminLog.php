<?php
// +----------------------------------------------------------------------
// | TP5CMS 内容管理系统 后台管理 单元类
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.gsdata.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: justin.郑 <3907721@qq.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\model\AdminLog as AdminLogModel;

class AdminLog extends Base{
    public function index(){
    	$this->assign('navmenutitle','管理员管理');
        $this->assign('navmenutitlenav','管理员日志');

        $allist = AdminLogModel::order('id desc')->select();
        $this->assign('count',count($allist));
        $this->assign('allist',$allist);

        return $this->fetch();
    }
}
