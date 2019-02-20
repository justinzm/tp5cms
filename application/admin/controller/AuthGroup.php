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
use app\admin\model\AuthGroup as AuthGroupModel;
use app\admin\model\AuthRule  as AuthRuleModel;

class AuthGroup extends Base{
    public function index(){
    	$this->assign('navmenutitle','管理员管理');
        $this->assign('navmenutitlenav','权限组管理');

        $aglist = AuthGroupModel::all();
        $this->assign('count',count($aglist));
        $this->assign('aglist',$aglist);

        return $this->fetch();
    }

    //添加
    public function add(){
    	return $this->fetch();
    }

    //插入
    public function insert(){
    	$result = AuthGroupModel::create(input('post.'));
    	if($result){
    		return showApiJson(200,'成功');
    	}else{
    		return showApiJson(400,'失败');
    	}
    }

    //编辑
    public function edit(){
    	$agfind = AuthGroupModel::get(input('get.id'));
    	$this->assign('agfind',$agfind);
    	return $this->fetch();
    }

    //修改
    public function update(){
        $result = AuthGroupModel::update(input('post.'));
        if($result){
            return showApiJson(200,'成功');
        }else{
            return showApiJson(400,'失败');
        }
    }

    //启动
    public function status(){
    	$result = AuthGroupModel::get(input('post.id'));
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
            $result = AuthGroupModel::destroy($id);
            if($result){
                return showApiJson(200,'成功');
            }else{
                return showApiJson(400,'失败');
            }
        }else if(!empty($did)){
            $result = AuthGroupModel::destroy($did);
            if($result){
                return showApiJson(200,'成功');
            }else{
                return showApiJson(400,'失败');
            }
        }else{
            return showApiJson(400,'失败');
        }
    }


    /**
     * 授权
     * @param $id
     * @return mixed
     */
    public function auth($id) {
        return $this->fetch('auth', ['id' => $id]);
    }

    /**
     * AJAX获取规则数据
     * @param $id
     * @return mixed
     */
    public function getJson($id) {
        $auth_group_data = AuthGroupModel::find($id)->toArray();
        $auth_rules      = explode(',', $auth_group_data['rules']);

        $auth_rule_list  = AuthRuleModel::field('id,pid,title')->select();

        foreach ($auth_rule_list as $key => $value) {
            in_array($value['id'], $auth_rules) && $auth_rule_list[$key]['checked'] = true;
        }

        return $auth_rule_list;
    }

    /**
     * 更新权限组规则
     * @param $id
     * @param $auth_rule_ids
     */
    public function updateAuthGroupRule($id, $auth_rule_ids = '') {
        if ($this->request->isPost()) {
            if ($id) {
                $group_data['id']    = $id;
                $group_data['rules'] = is_array($auth_rule_ids) ? implode(',', $auth_rule_ids) : '';

                if (AuthGroupModel::update($group_data, $id) !== false) {
                    $this->success('授权成功');
                } else {
                    $this->error('授权失败');
                }
            }
        }
    }
}
