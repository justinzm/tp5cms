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
use app\admin\model\Section as SectionModel;
use app\admin\model\Category as CategoryModel;

class Category extends Base{
    public function index(){
    	$this->assign('navmenutitle','内容管理');
        $this->assign('navmenutitlenav','分类管理');

        $clist = CategoryModel::all();
        $this->assign('count',count($clist));
        $this->assign('clist',$clist);

        return $this->fetch();
    }

    //添加
    public function add(){
        $slist = SectionModel::where('status',1)->select();
        $this->assign('slist',$slist);
    	return $this->fetch();
    }

    //插入
    public function insert(){
    	$result = CategoryModel::create(input('post.'));
    	if($result){
    		return showApiJson(200,'成功');
    	}else{
    		return showApiJson(400,'失败');
    	}
    }

    //编辑
    public function edit(){
        $slist = SectionModel::where('status',1)->select();
        $this->assign('slist',$slist);
        
    	$cfind = CategoryModel::get(input('get.id'));
    	$this->assign('cfind',$cfind);
    	return $this->fetch();
    }

    //修改
    public function update(){
        $result = CategoryModel::update(input('post.'));
        if($result){
            return showApiJson(200,'成功');
        }else{
            return showApiJson(400,'失败');
        }   
    }

    //启动
    public function status(){
    	$result = CategoryModel::get(input('post.id'));
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
            $result = CategoryModel::destroy($id);
            if($result){			 
                return showApiJson(200,'成功');
            }else{
                return showApiJson(400,'失败');
            }
        }else if(!empty($did)){
            $result = CategoryModel::destroy($did);
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