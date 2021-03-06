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
use app\admin\model\AuthRule as AuthRuleModel;

class Menu extends Base{
    protected function _initialize() {
        parent::_initialize();

        $arlist = AuthRuleModel::order(['sort' => 'desc', 'id' => 'asc'])->select();
        $arlist = array2level($arlist);
        $this->assign('count',count($arlist));
        $this->assign('arlist',$arlist);
    }

    public function index(){
    	$this->assign('navmenutitle','站点管理');
        $this->assign('navmenutitlenav','菜单管理');
        return $this->fetch();
    }

    //添加
    public function add($id = ''){
        $this->assign('pid',$id);
    	return $this->fetch();
    }

    //插入
    public function insert(){
    	$result = AuthRuleModel::create(input('post.'));
    	if($result){
    		return showApiJson(200,'成功');
    	}else{
    		return showApiJson(400,'失败');
    	}
    }

    //编辑
    public function edit(){
    	$arfind = AuthRuleModel::get(input('get.id'));
    	$this->assign('arfind',$arfind);
    	return $this->fetch();
    }

    //修改
    public function update(){
        $result = AuthRuleModel::update(input('post.'));
        if($result){
            return showApiJson(200,'成功');
        }else{
            return showApiJson(400,'失败');
        }   
    }

    //启动
    public function status(){
    	$result = AuthRuleModel::get(input('post.id'));
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
            $result = AuthRuleModel::destroy($id);
            if($result){			 
                return showApiJson(200,'成功');
            }else{
                return showApiJson(400,'失败');
            }
        }else if(!empty($did)){
            $result = AuthRuleModel::destroy($did);
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