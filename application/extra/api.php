<?php
/**
 * @ API 扩展配置文件 
 * @Author: justin.zhengming 
 * @Date: 2017-10-27 14:23:09 
 * @Last Modified time: 2017-10-27 14:23:09 
 * @Copyright (c) 2017 http://www.gsdata.cn All rights reserved. 
 */
return [
    'password_pre_halt' => '_#sing_zm', // 密码加密盐
    'aeskey'   => 'justin2017zm',       //aes 密钥 , 服务端和客户端必须保持一致
    'apptypes' => [
        'ios',
        'android',
        'WeChat',
    ],
    'app_sign_time' => 10,          // sign失效时间（秒）
    'app_sign_cache_time' => 20,     // sign 缓存失效时间
];