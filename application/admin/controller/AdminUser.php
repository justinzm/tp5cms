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
use app\admin\model\AdminUser as AdminUserModel;
use app\admin\model\AuthGroup as AuthGroupModel;
use app\admin\model\AuthGroupAccess as AuthGroupAccessModel;
use think\Config;

class AdminUser extends Base{
    public function index(){
    	$this->assign('navmenutitle','管理员管理');
        $this->assign('navmenutitlenav','管理员列表');

        $aulist = AdminUserModel::all();
        $this->assign('count',count($aulist));
        $this->assign('aulist',$aulist);
        
        return $this->fetch();
    }

    //添加
    public function add(){
        $aglist = AuthGroupModel::all();
        $this->assign('aglist',$aglist);
    	return $this->fetch();
    }

    //插入
    public function insert(){
        $data = $this->request->post();
        $d['password']      = md5($data['password'] . Config::get('salt'));
        $d['username']      = $data['username'];
        $d['status']        = $data['status'];
        $d['last_login_ip'] = $this->request->ip();

    	$result = AdminUserModel::create($d);
    	if($result){
            $da['uid'] = $result->id;
            $da['group_id'] = $data['group_id'];

            $res = AuthGroupAccessModel::create($da);
            if($res){
                return showApiJson(200,'成功');
            }    		
    	}else{
    		return showApiJson(400,'失败');
    	}
    }

    //编辑
    public function edit(){
        $aglist = AuthGroupModel::all();
        $this->assign('aglist',$aglist);

        $agafind = AuthGroupAccessModel::where('uid',input('get.id'))->find();
        $this->assign('agafind',$agafind);

    	$aufind = AdminUserModel::get(input('get.id'));
    	$this->assign('aufind',$aufind);
    	return $this->fetch();
    }

    //修改
    public function update(){
        $data = $this->request->post();

        if(isset($data['password'])){
            $d['password']  = md5($data['password'] . Config::get('salt'));
        }
        $d['id']            = $data['id'];
        $d['username']      = $data['username'];
        $d['status']        = $data['status'];
        $d['last_login_ip'] = $this->request->ip();

        $result = AdminUserModel::update($d);
        if($result){
            $aga = AuthGroupAccessModel::where('uid', $data['id'])->find();
            if($aga['group_id'] == $data['group_id']){
                return showApiJson(200,'成功');
            }else{
                $res = AuthGroupAccessModel::where('uid', $data['id'])->update(['group_id' => $data['group_id']]);
                if($res){
                    return showApiJson(200,'成功');
                }
            }            
        }else{
            return showApiJson(400,'失败');
        }   
    }

    //启动
    public function status(){
    	$result = AdminUserModel::get(input('post.id'));
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
            $result = AdminUserModel::destroy($id);
            
            for($i = 0; $i < count($did); $i++){
                $where['uid'] = $did[$i];
                AuthGroupAccessModel::where($where)->delete();
                unset($where);
            }
            if($result){
                return showApiJson(200,'成功');
            }else{
                return showApiJson(400,'失败');
            }
        }else if(!empty($did)){
            $result = AdminUserModel::destroy($did);
            $agam = AuthGroupAccessModel::where('uid',$did)->delete();
            if($result and $agam){
                return showApiJson(200,'成功');
            }else{
                return showApiJson(400,'失败');
            }
        }else{
            return showApiJson(400,'失败');
        }
    }
}