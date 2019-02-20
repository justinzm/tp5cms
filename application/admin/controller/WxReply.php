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
use app\admin\model\WxReply as WxReplyModel;

class WxReply extends Base{
    public function index(){
    	$this->assign('navmenutitle','微信基础管理');
        $this->assign('navmenutitlenav','关注回复管理');

        $wrfind = WxReplyModel::get(1);
        $this->assign('count',count($wrfind));
        $this->assign('wrfind',$wrfind);

        return $this->fetch();
    }

    //修改
    public function update(){
        $result = WxReplyModel::update(input('post.'));
        if($result){
            return showApiJson(200,'成功');
        }else{
            return showApiJson(400,'失败');
        }   
    }
}