<?php
// +----------------------------------------------------------------------
// | TP5CMS 内容管理系统 后台管理 公共类
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.gsdata.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: justin.郑 <3907721@qq.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Session;
use think\auth\Auth;
use think\Db;
use app\admin\model\AuthRule as AuthRuleModel;
use app\admin\model\Config as ConfigModel;

class Base extends Controller{
	protected function _initialize(){
		header("Content-Type:text/html; charset=utf-8");
		parent::_initialize();
        $this->webCon();
		$this->checkAuth();
        $this->getMenu();
	}

    /**
    * 站点信息
    *
    */
    protected function webCon(){
        $c = ConfigModel::where('id', 1)->find();
        $this->assign('confind',$c);
        return $c;
    }

    /**
     * 权限检查
     * @return bool
     */
    protected function checkAuth() {
        if (!Session::has('admin_id')) {
            $this->redirect('admin/login/index');
        }

        $module     = $this->request->module();
        $controller = $this->request->controller();
        $action     = $this->request->action();

        // 排除权限
        $not_check = ['admin/Index/index', 'admin/Index/welcome', 'admin/Sys/cleanCache'];

        if (!in_array($module . '/' . $controller . '/' . $action, $not_check)) {
            $auth     = new Auth();
            $admin_id = Session::get('admin_id');
            if (!$auth->check($module . '/' . $controller . '/' . $action, $admin_id) && $admin_id != 1) {
                $this->error('没有权限');
            }
        }
    }


    /**
     * 获取侧边栏菜单
     */
    protected function getMenu() {
        $menu     = [];
        $admin_id = Session::get('admin_id');
        $auth     = new Auth();

        $auth_rule_list = Db::name('auth_rule')->where('status', 1)->order(['sort' => 'desc', 'id' => 'asc'])->select();

        foreach ($auth_rule_list as $value) {
            if ($auth->check($value['name'], $admin_id) || $admin_id == 1) {
                $menu[] = $value;
            }
        }

        $menu = !empty($menu) ? array2tree($menu) : [];

        $auth_group_access = Db::name('AuthGroupAccess')->where('uid',$admin_id)->find();
        $auth_group = Db::name('AuthGroup')->where('id',$auth_group_access["group_id"])->find();

        $this->assign('rules', $auth_group["rules"]);
        $this->assign('menu', $menu);
    }

    //上传图片
    public function uploadImg(Request $request){
        // 获取表单上传文件
        $file = $request->file('file');
        if (empty($file)) {
            $this->error('请选择上传文件');
        }

        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->validate(['ext' => 'jpg,jpeg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
        if ($info) {
            //$this->success('文件上传成功：' . $info->getRealPath());
            return json('./public/uploads/'.$info->getSaveName());

        } else {
            // 上传失败获取错误信息
            //$this->error($file->getError());
        }
    }


    function api_notice_increment($url, $data){
        $ch = curl_init();
        $curl;
        $header = "Accept-Charset: utf-8";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        //curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($ch);
        if (curl_errno($ch)) {
            return false;
        }else{
            //curl_close($curl);
            return true;
        }
    }

    function curlGet($url){
        $ch = curl_init();
        $header = "Accept-Charset: utf-8";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        //curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $temp = curl_exec($ch);
        return $temp;
    }
}