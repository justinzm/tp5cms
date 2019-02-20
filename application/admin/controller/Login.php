<?php
// +----------------------------------------------------------------------
// | TP5CMS 内容管理系统 后台登录
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.gsdata.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: justin.郑 <3907721@qq.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;
use app\admin\model\Config as ConfigModel;
use think\Controller;
use think\Db;
use think\Config;
use think\Session;

class Login extends Controller{
	protected function _initialize() {
        $c = ConfigModel::where('id', 1)->find();
		$this->assign('confind',$c);
    }

    public function index(){
        //return $u;
        return $this->fetch();
    }

    /**
     * 登录验证
     * @return string
     */
    public function login() {
        $data = $this->request->only(['username', 'password', 'verify']);

        //验证码
        $captcha = new \think\captcha\Captcha();
        if (!$captcha->check($data['verify'])) {
            $this->error('验证码错误');
        } else {
            //验证码正确
            $where['username'] = $data['username'];
            $where['password'] = md5($data['password'] . Config::get('salt'));

            $admin_user = Db::name('admin_user')->field('id,username,status')->where($where)->find();

            if (!empty($admin_user)) {
                if ($admin_user['status'] != 1) {
                    $this->error('当前用户已禁用');
                } else {
                    Session::set('admin_id', $admin_user['id']);
                    Session::set('admin_name', $admin_user['username']);
                    Db::name('admin_user')->update(
                        [
                            'last_login_time' => date('Y-m-d H:i:s', time()),
                            'last_login_ip'   => $this->request->ip(),
                            'id'              => $admin_user['id']
                        ]
                    );
                    adminLog('后台登录');
                    $this->success('登录成功');
                    //$this->redirect('admin/index/index');
                }
            } else {
                $this->error('用户名或密码错误');
            }
        }
    }

    /**
     * 退出登录
     */
    public function logout() {
        Session::delete('admin_id');
        Session::delete('admin_name');
                
        $this->redirect('admin/login/index');
    }
}