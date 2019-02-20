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
use app\admin\model\Menu     as MenuModel;
use app\admin\model\MenuItem as MenuItemModel;

class MenuItem extends Base{
    public function index(){
    	$this->assign('navmenutitle','站点管理');
        $this->assign('navmenutitlenav','菜单项管理');

        $milist = MenuItemModel::all();
        $this->assign('count',count($milist));
        $this->assign('milist',$milist);

        return $this->fetch();
    }

    //添加
    public function add(){
        $mlist = MenuModel::where('status',1)->select();
        $this->assign('mlist',$mlist);
    	return $this->fetch();
    }

    //插入
    public function insert(){
    	$result = MenuItemModel::create(input('post.'));
    	if($result){
    		return showApiJson(200,'成功');
    	}else{
    		return showApiJson(400,'失败');
    	}
    }

    //编辑
    public function edit(){
        $mlist = MenuModel::where('status',1)->select();
        $this->assign('mlist',$mlist);
        
    	$mifind = MenuItemModel::get(input('get.id'));
    	$this->assign('mifind',$mifind);
    	return $this->fetch();
    }

    //修改
    public function update(){
        $result = MenuItemModel::update(input('post.'));
        if($result){
            return showApiJson(200,'成功');
        }else{
            return showApiJson(400,'失败');
        }   
    }

    //启动
    public function status(){
    	$result = MenuItemModel::get(input('post.id'));
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
            $result = MenuItemModel::destroy($id);
            if($result){			 
                return showApiJson(200,'成功');
            }else{
                return showApiJson(400,'失败');
            }
        }else if(!empty($did)){
            $result = MenuItemModel::destroy($did);
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