<?php
/*
 * @ aes 加密 解密类库
 * @Author: justin.zhengming 
 * @Date: 2017-10-27 14:27:53 
 * @Last Modified time: 2017-10-27 14:27:53 
 * @Copyright (c) 2017 http://www.gsdata.cn All rights reserved. 
 */
namespace app\lib;

class Aes {
    /**向量
     * @var string
     */
    private static $iv = "1234567890123456";//16位
    /**
     * 默认秘钥
     */
    const KEY = 'justin2017zm2017';//16位

    public static function init($iv = ''){
        self::$iv = $iv;
    }

    /**
     * 加密字符串
     * @param string $data 字符串
     * @param string $key  加密key
     * @return string
     */
    public static function encrypt($data = '', $key = self::KEY){
        $encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, self::$iv);
        return base64_encode($encrypted);
    }

    /**
     * 解密字符串
     * @param string $data 字符串
     * @param string $key  加密key
     * @return string
     */
    public static function decrypt($data = '', $key = self::KEY){
        $decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($data), MCRYPT_MODE_CBC, self::$iv);
        return rtrim($decrypted, "\0");
    }
}