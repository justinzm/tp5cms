<?php
// +----------------------------------------------------------------------
// | TP5CMS 内容管理系统 后台管理 单页类
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.gsdata.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: justin.郑 <3907721@qq.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\model\Page as PageModel;

class Page extends Base{
    public function index(){
    	$this->assign('navmenutitle','内容管理');
        $this->assign('navmenutitlenav','单页管理');

        $plist = PageModel::all();
        $this->assign('count',count($plist));
        $this->assign('plist',$plist);

        return $this->fetch();
    }

    //添加
    public function add(){
    	return $this->fetch();
    }

    //插入
    public function insert(){
    	$result = PageModel::create(input('post.'));
    	if($result){
    		return showApiJson(200,'成功');
    	}else{
    		return showApiJson(400,'失败');
    	}
    }

    //编辑
    public function edit(){
    	$pfind = PageModel::get(input('get.id'));
    	$this->assign('pfind',$pfind);
    	return $this->fetch();
    }

    //修改
    public function update(){
        $result = PageModel::update(input('post.'));
        if($result){
            return showApiJson(200,'成功');
        }else{
            return showApiJson(400,'失败');
        }   
    }

    //启动
    public function status(){
    	$result = PageModel::get(input('post.id'));
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
            $result = PageModel::destroy($id);
            if($result){			 
                return showApiJson(200,'成功');
            }else{
                return showApiJson(400,'失败');
            }
        }else if(!empty($did)){
            $result = PageModel::destroy($did);
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