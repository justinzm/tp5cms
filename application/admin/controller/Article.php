<?php
// +----------------------------------------------------------------------
// | TP5CMS 内容管理系统 后台管理 文章类
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.gsdata.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: justin.郑 <3907721@qq.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\model\Article  as ArticleModel;
use app\admin\model\Section  as SectionModel;
use app\admin\model\Category as CategoryModel;

class Article extends Base{
    public function index(){
    	$this->assign('navmenutitle','内容管理');
        $this->assign('navmenutitlenav','文章管理');

        $alist = ArticleModel::withTrashed()->select();
        $this->assign('count',count($alist));
        $this->assign('alist',$alist);

        return $this->fetch();
    }

    //添加
    public function add(){
        $slist = SectionModel::where('status',1)->select();
        $this->assign('slist',$slist);

        $clist = CategoryModel::where('status',1)->select();
        $this->assign('clist',$clist);

    	return $this->fetch();
    }

    //插入
    public function insert(){
    	$result = ArticleModel::create(input('post.'));
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

        $clist = CategoryModel::where('status',1)->select();
        $this->assign('clist',$clist);
        
    	$afind = ArticleModel::get(input('get.id'));
    	$this->assign('afind',$afind);
    	return $this->fetch();
    }

    //修改
    public function update(){
        $result = ArticleModel::update(input('post.'));
        if($result){
            return showApiJson(200,'成功');
        }else{
            return showApiJson(400,'失败');
        }   
    }

    //启动
    public function status(){
    	$result = ArticleModel::get(input('post.id'));
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
            $result = ArticleModel::destroy($id);
            if($result){			 
                return showApiJson(200,'成功');
            }else{
                return showApiJson(400,'失败');
            }
        }else if(!empty($did)){
            $result = ArticleModel::destroy($did);
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