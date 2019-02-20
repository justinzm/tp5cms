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
use app\admin\model\Ad as AdModel;

class Ad extends Base{
    public function index(){
    	$this->assign('navmenutitle','扩展管理');
        $this->assign('navmenutitlenav','广告管理');

        $adlist = AdModel::all();
        $this->assign('count',count($adlist));
        $this->assign('adlist',$adlist);

        return $this->fetch();
    }

    //添加
    public function add(){
    	return $this->fetch();
    }

    //插入
    public function insert(){
    	$result = AdModel::create(input('post.'));
    	if($result){
    		return showApiJson(200,'成功');
    	}else{
    		return showApiJson(400,'失败');
    	}
    }

    //编辑
    public function edit(){
    	$adfind = AdModel::get(input('get.id'));
    	$this->assign('adfind',$adfind);
    	return $this->fetch();
    }

    //修改
    public function update(){
        $result = AdModel::update(input('post.'));
        if($result){
            return showApiJson(200,'成功');
        }else{
            return showApiJson(400,'失败');
        }
    }

    //启动
    public function status(){
    	$result = AdModel::get(input('post.id'));
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
            $result = AdModel::destroy($id);
            if($result){
                return showApiJson(200,'成功');
            }else{
                return showApiJson(400,'失败');
            }
        }else if(!empty($did)){
            $result = AdModel::destroy($did);
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
