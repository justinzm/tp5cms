<?php
// +----------------------------------------------------------------------
// | TP5CMS 内容管理系统 模型
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.gsdata.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: justin.郑 <3907721@qq.com>
// +----------------------------------------------------------------------

namespace app\admin\model;
use think\Model;
use app\admin\model\menu;

class MenuItem extends Model{
	protected function getMenuTitleAttr($menu_id, $data){
		$m = Menu::get($data['menu_id']);
		return $m->title;
	}
}