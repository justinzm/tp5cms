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

class WxImgs extends Model{
	protected $autoWriteTimestamp = true;

	protected $type = [
		'create_time' => 'timestamp:Y-m-d',
	];

	
}