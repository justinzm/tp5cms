<?php
// +----------------------------------------------------------------------
// | TP5CMS 内容管理系统 模型
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.gsdata.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: justin.郑 <3907721@qq.com>
// +----------------------------------------------------------------------

namespace app\wx\model;
use think\Model;

class WxImg extends Model{
	// 设置数据表（不含前缀）
	protected $name = 'WxImgtext';
	protected $type = [
		'create_time' => 'timestamp:Y-m-d',
	];
}