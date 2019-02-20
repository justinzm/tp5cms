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
use app\admin\model\Config as ConfigModel;

class Conf extends Base{
    public function index(){
    	$this->assign('navmenutitle','站点管理');
        $this->assign('navmenutitlenav','站点配置');

        $cfind = ConfigModel::get(1);
        $this->assign('count',count($cfind));
        $this->assign('cfind',$cfind);

        return $this->fetch();
    }

    //修改
    public function update(){
        $result = ConfigModel::update(input('post.'));
        if($result){
            return showApiJson(200,'成功');
        }else{
            return showApiJson(400,'失败');
        }   
    }
}