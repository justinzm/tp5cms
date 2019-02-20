<?php
// +----------------------------------------------------------------------
// | TP5CMS 内容管理系统 微信模块 单页显示
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.gsdata.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: justin.郑 <3907721@qq.com>
// +----------------------------------------------------------------------
namespace app\wx\controller;
use think\Controller;
use app\wx\model\WxImg as WxImgModel;

class Page extends Base {
    public function Page($id){
        $wifind = WxImgModel::get($id);
        WxImgModel::where('id', $id)->setInc('hits', 1);
        $this->assign('wifind',$wifind);
        return $this->fetch();
    }

    //点赞

    public function praise($id){
        $result = WxImgModel::where('id', $id)->setInc('praise', 1);

        if($result){
    		return json(['msg' => '成功'], 200);
    	}else{
    		return json(0);
    	}
    }
}
?>
