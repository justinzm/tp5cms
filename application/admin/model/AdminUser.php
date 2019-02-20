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

class AdminUser extends Model{
	protected $autoWriteTimestamp = true;
	protected $updateTime = false;
	
	protected $type = [
		'create_time' => 'timestamp:Y-m-d',
	];

	// public function prof(){
	// 	return $this->hasOne('AuthGroupAccess','uid','id');
	// }

	public function getGroupTitleAttr($value,$data){
		$aga = Db::name('AuthGroupAccess')->where('uid',$data['id'])->find();
		$ag  = Db::name('AuthGroup')->where('id',$aga['group_id'])->find();
  		return $ag['title'];
	}
}