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
use app\admin\model\WxImgs as WxImgsModel;
use app\admin\model\WxImg  as WxImgModel;

class WxImgs extends Base{
    public function index(){
    	$this->assign('navmenutitle','微信基础管理');
        $this->assign('navmenutitlenav','微信多图文管理');

        $wilist = WxImgsModel::all();
        $this->assign('count',count($wilist));
        $this->assign('wilist',$wilist);

        return $this->fetch();
    }

    //添加
    public function add(){
        $witlist = WxImgModel::where('status',1)->select();
        $this->assign('witlist',$witlist);
        $this->assign('witlists',$witlist);
    	return $this->fetch();
    }

    //插入
    public function insert(){
    	$result = WxImgsModel::create(input('post.'));
    	if($result){
    		return showApiJson(200,'成功');
    	}else{
    		return showApiJson(400,'失败');
    	}
    }

    //编辑
    public function edit(){
        $witlist = WxImgModel::where('status',1)->select();
        $this->assign('witlist',$witlist);
        $this->assign('witlists',$witlist);

    	$wifind = WxImgsModel::get(input('get.id'));
    	$this->assign('wifind',$wifind);

        $chk = explode(",",$wifind['wid']);
        array_pop($chk);
        $this->assign('chk',$chk);
        
    	return $this->fetch();
    }

    //修改
    public function update(){
        $result = WxImgsModel::update(input('post.'));
        if($result){
            return showApiJson(200,'成功');
        }else{
            return showApiJson(400,'失败');
        }   
    }

    //启动
    public function status(){
    	$result = WxImgsModel::get(input('post.id'));
    	if(input('post.status') == 0){
    		$result->status = 1;
    	}elseif(input('post.status') == 1){
    		$result->status = 0;
    	}

    	if (false !== $result->save()) {
			return showApiJson(200,'成功');
		}
    }

    //删除
    public function delete(){
        $did = input('post.did/a');
        if(is_array($did)){
        	$id = implode(',',$did);
            $result = WxImgsModel::destroy($id);
            if($result){			 
                return showApiJson(200,'成功');
            }else{
                return showApiJson(400,'失败');
            }
        }else if(!empty($did)){
            $result = WxImgsModel::destroy($did);
            if($result){			 
                return showApiJson(200,'成功');
            }else{
                return showApiJson(400,'失败');
            }
        }else{
            return showApiJson(400,'失败');
        }
    }
}