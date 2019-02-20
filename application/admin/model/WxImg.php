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

class WxImg extends Model{
	// 设置数据表（不含前缀）
	protected $name = 'WxImgtext';

	protected $autoWriteTimestamp = true;

	protected $type = [
		'create_time' => 'timestamp:Y-m-d',
	];

	//截图 320*200
	public function setImgAttr($value,$data){
		$image = \think\Image::open($value);
		$image->thumb(320,200,\think\Image::THUMB_CENTER)->save($value);
		return $value;
	}
}