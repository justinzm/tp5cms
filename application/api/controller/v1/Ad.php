<?php
// +----------------------------------------------------------------------
// | TP5CMS 内容管理系统 API接口 广告 Banner 文件
// +----------------------------------------------------------------------
// | Copyright (c) 2007-2016 http://whuit.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: justin.郑 <3907721@qq.com>
// +----------------------------------------------------------------------
namespace app\api\controller\v1;
use mumbaicat\makeapidoc\ApiDoc;

use app\api\controller\ApiBase;

use app\api\model\Ad as AdModel;
use app\api\validate\Ad as AdValidate;
use app\lib\exception\AdMissException;
use think\Controller;



class Ad extends ApiBase{
    /**
     * 获取所有列表
     * api GET api.php/index/index/all
     * @param integer $page 页数
     * @param integer $limit 每页个数
     * @return integer $code 状态码
     * @return string $msg 返回消息
     * @return array $void 结果
     */
    public function getAd($id){
        (new AdValidate())->goCheck();

        $ad = AdModel::get($id);
        if(!$ad){
            throw new AdMissException();
        }
        return showApiJson(10001, 'ok', 201, $ad);
    }
}
