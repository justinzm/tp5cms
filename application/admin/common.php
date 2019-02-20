<?php
use think\Db;
use think\Request;

/**
 * 管理员操作记录
 * @param $log_url 操作URL
 * @param $log_info 记录信息
 */
function adminLog($log_info){
	$request = Request::instance();

	$add['log_time'] = time();
	$add['admin_id'] = input('session.admin_id');
	$add['log_info'] = $log_info;
	$add['log_ip']   = $request->ip();;
	$add['log_url']  = $request->module().'/'.$request->controller().'/'.$request->action();
    Db::name('admin_log')->insert($add);
}

/**
 * 数组层级缩进转换
 * @param array $array
 * @param int   $pid
 * @param int   $level
 * @return array
 */
function array2level($array, $pid = 0, $level = 1) {
    static $list = [];
    foreach ($array as $v) {
        if ($v['pid'] == $pid) {
            $v['level'] = $level;
            $list[]     = $v;
            array2level($array, $v['id'], $level + 1);
        }
    }
    return $list;
}

/**
 * 构建层级（树状）数组
 * @param array  $array 要进行处理的一维数组，经过该函数处理后，该数组自动转为树状数组
 * @param string $pid 父级ID的字段名
 * @param string $child_key_name 子元素键名
 * @return array|bool
 */
function array2tree(&$array, $pid = 'pid', $child_key_name = 'children') {
    $counter = array_children_count($array, $pid);
    if ($counter[0] == 0)
        return false;
    $tree = [];
    while (isset($counter[0]) && $counter[0] > 0) {
        $temp = array_shift($array);
        if (isset($counter[$temp['id']]) && $counter[$temp['id']] > 0) {
            array_push($array, $temp);
        } else {
            if ($temp[$pid] == 0) {
                $tree[] = $temp;
            } else {
                $array = array_child_append($array, $temp[$pid], $temp, $child_key_name);
            }
        }
        $counter = array_children_count($array, $pid);
    }
    return $tree;
}

/**
 * 子元素计数器
 * @param $array
 * @param $pid
 * @return array
 */
function array_children_count($array, $pid) {
    $counter = [];
    foreach ($array as $item) {
        $count = isset($counter[$item[$pid]]) ? $counter[$item[$pid]] : 0;
        $count++;
        $counter[$item[$pid]] = $count;
    }

    return $counter;
}

/**
 * 把元素插入到对应的父元素$child_key_name字段
 * @param        $parent
 * @param        $pid
 * @param        $child
 * @param string $child_key_name 子元素键名
 * @return mixed
 */
function array_child_append($parent, $pid, $child, $child_key_name) {
    foreach ($parent as &$item) {
        if ($item['id'] == $pid) {
            if (!isset($item[$child_key_name]))
                $item[$child_key_name] = [];
            $item[$child_key_name][] = $child;
            //dump($item);
        }

    }

    return $parent;
}

/**
 * 循环删除目录和文件
 * @param string $dir_name
 * @return bool
 */
function delete_dir_file($dir_name) {
    $result = false;
    if(is_dir($dir_name)){
        if ($handle = opendir($dir_name)) {
            while (false !== ($item = readdir($handle))) {
                if ($item != '.' && $item != '..') {
                    if (is_dir($dir_name . DS . $item)) {
                        delete_dir_file($dir_name . DS . $item);
                    } else {
                        unlink($dir_name . DS . $item);
                    }
                }
            }
            closedir($handle);
            if (rmdir($dir_name)) {
                $result = true;
            }
        }
    }

    return $result;
}

/**
 * 判断是否为手机访问
 * @return  boolean
 */
function is_mobile() {
    static $is_mobile;

    if (isset($is_mobile)) {
        return $is_mobile;
    }

    if (empty($_SERVER['HTTP_USER_AGENT'])) {
        $is_mobile = false;
    } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false
              || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
              || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
              || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
              || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
              || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
              || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false
    ) {
        $is_mobile = true;
    } else {
        $is_mobile = false;
    }

    return $is_mobile;
}

/**
+----------------------------------------------------------
* 取得Ad表内容
* 示例:{:Ad(1);}
+----------------------------------------------------------
* @access ad
+----------------------------------------------------------
* @param int $id 编号
+----------------------------------------------------------
 */
function ads($id){
  $ad = M('Ad');
  $data['id'] = $id;
  $data['status'] = 1;
  $adfind = $ad->where($data)->find();
  unset($data);
    
    if($adfind['url']==""){
        $str =  "<img src='".$adfind['img']."' title='".$adfind['intro']."' />";
    }else{
        $str =  "<a href='".$adfind['url']."'><img src='".$adfind['img']."' title='".$adfind['intro']."' /></a>";
    }
    return $str;
}

function ad($id){
  $ad = M('Ad');
  $data['id'] = $id;
  $data['status'] = 1;
  $adfind = $ad->where($data)->find();
  unset($data);

  $str =  $adfind['img'];
  return $str;
}
    
/**
+----------------------------------------------------------
* 字符串截取，支持中文和其他编码
+----------------------------------------------------------
* @static
* @access public
+----------------------------------------------------------
* @param string $str 需要转换的字符串
* @param string $start 开始位置
* @param string $length 截取长度
* @param string $charset 编码格式
* @param string $suffix 截断显示字符
+----------------------------------------------------------
* @return string
+----------------------------------------------------------
*/
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true){
  if(function_exists("mb_substr")){
    if($suffix){
      return mb_substr($str, $start, $length, $charset)."...";
    }else{
      return mb_substr($str, $start, $length, $charset);
    }
  }elseif(function_exists('iconv_substr')) {
    if($suffix){
      return iconv_substr($str,$start,$length,$charset)."...";
    }else{
      return iconv_substr($str,$start,$length,$charset);
    }
  }
  $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
  preg_match_all($re[$charset], $str, $match);
  $slice = join("",array_slice($match[0], $start, $length));
  if($suffix){ 
    return $slice."...";
  }else{
    return $slice;
  }
}

/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 */
function format_bytes($size, $delimiter = '') {
  $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
  for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
  return round($size, 2) . $delimiter . $units[$i];
}

/**
 * 获取随机字符串
 * @param int $randLength  长度
 * @param int $addtime  是否加入当前时间戳
 * @param int $includenumber   是否包含数字
 * @return string
 */
function get_rand_str($randLength=6,$addtime=1,$includenumber=0){
  if ($includenumber){
    $chars='abcdefghijklmnopqrstuvwxyzABCDEFGHJKLMNPQEST123456789';
  }else {
    $chars='abcdefghijklmnopqrstuvwxyz';
  }
  $len=strlen($chars);
  $randStr='';
  for ($i=0;$i<$randLength;$i++){
    $randStr.=$chars[rand(0,$len-1)];
  }
  $tokenvalue=$randStr;
  if ($addtime){
    $tokenvalue=$randStr.time();
  }
  return $tokenvalue;
}

// 递归删除文件夹
function delFile($dir,$file_type='') {
  if(is_dir($dir)){
    $files = scandir($dir);
    //打开目录 //列出目录中的所有文件并去掉 . 和 ..
    foreach($files as $filename){
      if($filename!='.' && $filename!='..'){
        if(!is_dir($dir.'/'.$filename)){
          if(empty($file_type)){
            unlink($dir.'/'.$filename);
          }else{
            if(is_array($file_type)){
              //正则匹配指定文件
              if(preg_match($file_type[0],$filename)){
                unlink($dir.'/'.$filename);
              }
            }else{
              //指定包含某些字符串的文件
              if(false!=stristr($filename,$file_type)){
                unlink($dir.'/'.$filename);
              }
            }
          }
        }else{
          delFile($dir.'/'.$filename);
          rmdir($dir.'/'.$filename);
        }
      }
    }
  }else{
    if(file_exists($dir)) unlink($dir);
  }
}

//管理员管理--获得权限组名称
function ag_title($id){
  $ag = Db::name('AuthGroup')->where('id',$id)->find();
  echo $ag['title'];
}