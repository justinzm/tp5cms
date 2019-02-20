<?php
/*
 * @ Iauth 相关 类
 * @Author: justin.zhengming 
 * @Date: 2017-10-27 14:49:37 
 * @Last Modified time: 2017-10-27 14:49:37 
 * @Copyright (c) 2017 http://www.gsdata.cn All rights reserved. 
 */
namespace app\lib;
use app\lib\Aes;
use think\Cache;

class IAuth {
    /**
     * 设置密码
     * @param string $data
     * @return string
     */
    public static function setPassword($data) {
        return md5($data.config('app.password_pre_halt'));
    }

    /**
     * 生成每次请求的sign
     * @param array $data
     * @return string
     */
    public static function setSign($data = []) {
        // 1 按字段排序
        ksort($data);
        // 2 拼接字符串数据
        $string = http_build_query($data);
        // 3 通过aes来加密
        $string = (new Aes())->encrypt($string);
       
        return $string;
    }

    /**
     * 检查sign是否正常
     * @param array $data
     * @param $data
     * @return boolen
     */
    public static function checkSignPass($data) {
        $str = (new Aes())->decrypt($data['sign']);

        if(empty($str)) {
            return false;
        }

        // diid=xx&app_type=3
        parse_str($str, $arr);

        if(!is_array($arr) || empty($arr['sign']) || $arr['sign'] != $data['sign'] ) {
            return false;
        }

        if(!config('app_debug')) {
            if ((time() - ceil($arr['time'] / 1000)) > config('api.app_sign_time')) {
                return false;
            }
            echo Cache::get($data['sign']);exit;
            // 唯一性判定
            if (Cache::get($data['sign'])) {
                return false;
            }
        }
        return true;
    }
}