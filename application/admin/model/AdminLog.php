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
use think\Db;

class AdminLog extends Model{
	protected $autoWriteTimestamp = false;
	protected $updateTime = false;

	// 定义类型转换
	protected $type = [
		'log_time' => 'timestamp:Y-m-d H:i:s',
	];

	public function getAdminIdAttr($value,$data){
		$au  = Db::name('AdminUser')->where('id',$data['admin_id'])->find();
  		return $au['username'];
	}


}