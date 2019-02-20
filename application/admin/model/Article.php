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
use traits\model\SoftDelete;

class Article extends Model{
	protected $autoWriteTimestamp = true;

	use SoftDelete;
	protected $deleteTime = 'delete_time';

	public function getSIdTitleAttr($s_id, $data){
		$sec = Db::name('Section')->where('id',$data['s_id'])->find();
		return $sec['title'];
	}

	public function getCIdTitleAttr($c_id, $data){
		$cat = Db::name('Category')->where('id',$data['c_id'])->find();
		return $cat['title'];
	}
}