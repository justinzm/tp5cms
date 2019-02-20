<?php
//接口模板
//======================================================================

/**
 * 通用化API接口数据输出
 * @param  [type]  $code   [业务状态码]
 * @param  [type]  $message  [信息提示]
 * @param  integer $httpCode [http状态码]
 * @param  array   $data     [数据]code
 * @return json [type]
 */
function showApiJson($code, $message, $httpCode = 200, $data = []){
    $data = [
        'code' => $code,
        'message' => $message,
        'data' => $data
    ];
    return json($data, $httpCode);
}