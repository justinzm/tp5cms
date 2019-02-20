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

class Page extends Model{
	// 定义类型转换
	protected $type = [
		'createtime' => 'timestamp:Y-m-d',
		'updatetime' => 'timestamp:Y-m-d',
	];

	protected $insert = ['createtime'];
	protected function setCreatetimeAttr($value, $data){
		return time();
	}

	protected $update = ['updatetime'];
	protected function setUpdatetimeAttr($value, $data){
		return time();
	}
}