<?php
// +----------------------------------------------------------------------
// | TP5CMS 内容管理系统 后台管理 
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.gsdata.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: justin.郑 <3907721@qq.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;
use app\admin\controller\Base;
use think\Db;
use think\Config;

class Tools extends Base{
    //列表
    public function index(){
    	$this->assign('navmenutitle','插件管理');
        $this->assign('navmenutitlenav','数据备份');

        $dbtables = Db::query('SHOW TABLE STATUS');
        //dump($dbtables);

        $total = 0;
        foreach ($dbtables as $k => $v) {
            $dbtables[$k]['size'] = format_bytes($v['Data_length'] + $v['Index_length']);
            $total += $v['Data_length'] + $v['Index_length'];
        }
        $this->assign('tlist', $dbtables);
        $this->assign('total', format_bytes($total));
        $this->assign('count', count($dbtables));

        return $this->fetch();
    }

    //优化
    public function optimize() {
        $table = input('post.table');
        if (empty($table)) {
            $this->error('请选择要优化的表');
        }

        if (Db::query("OPTIMIZE TABLE {$table}")) {
            exit(json_encode(array('stat'=>'ok','msg'=>"优化 ".$table." 表")));
        }
    }

    //修复
    public function repair() {
        $table = input('post.table');
        if (empty($table)) {
            $this->error('请选择要修复的表');
        }

        if (Db::query("REPAIR TABLE {$table} ")) {
            exit(json_encode(array('stat'=>'ok','msg'=>"修复 ".$table." 表")));
        }
    }

    //备份
    public function backup(){
        //$M = M();
        //防止备份数据过程超时
        function_exists('set_time_limit') && set_time_limit(0);
        //send_http_status('310');
        $tables = input('tables/a');

        if (empty($tables)) {
            $this->error('请选择要备份的数据表');
        }

        $time = time();//开始时间

        //检查文件或目录是否存在
        if(!file_exists(UPLOAD_PATH.'sqldata')){
            //函数创建目录
            mkdir(UPLOAD_PATH.'sqldata');
        }
        $path = UPLOAD_PATH."sqldata/".WEB_SITE."_tables_" . date("Ymd").get_rand_str(3,0);

        $pre = "# -----------------------------------------------------------\n";
        //取得表结构信息
        //1，表示表名和字段名会用``包着的,0 则不用``
     
        Db::execute("SET SQL_QUOTE_SHOW_CREATE = 1"); 
        $outstr = '';
        foreach ($tables as $table) {
            $outstr.="# 表的结构 {$table} \n";
            $outstr .= "DROP TABLE IF EXISTS `{$table}`;\n";
            $tmp = Db::query("SHOW CREATE TABLE {$table}");
            $outstr .= $tmp[0]['Create Table'] . " ;\n\n";

        }
        
        $sqlTable = $outstr;
        $outstr = "";
        $file_n = 1;
        $backedTable = array();

        //表中的数据
        foreach ($tables as $table) {
            $backedTable[] = $table;
            $outstr.="\n\n# 转存表中的数据：{$table} \n";
            $tableInfo = Db::query("SHOW TABLE STATUS LIKE '{$table}'");
            
            $page = ceil($tableInfo[0]['Rows'] / 10000) - 1;

            for ($i = 0; $i <= $page; $i++) {
                $query = Db::query("SELECT * FROM {$table} LIMIT " . ($i * 10000) . ", 10000");

                foreach ($query as $val) {
                    $temSql = "";
                    $tn = 0;
                    $temSql = '';
                    foreach ($val as $v) {
                        $temSql.=$tn == 0 ? "" : ",";
                        $temSql.=$v == '' ? "''" : "'{$v}'";
                        $tn++;
                    }
                    $temSql = "INSERT INTO `{$table}` VALUES ({$temSql});\n";
                    $sqlNo = "\n# Time: " . date("Y-m-d H:i:s") . "\n" .
                             "# -----------------------------------------------------------\n" .
                             "# SQLFile Label：#{$file_n}\n# -----------------------------------------------------------\n\n\n";
                       if ($file_n == 1) {
                        $sqlNo = "# Description:备份的数据表[结构]：" . implode(",", $tables) . "\n".
                                 "# Description:备份的数据表[数据]：" . implode(",", $backedTable) . $sqlNo;
                    } else {
                        $sqlNo = "# Description:备份的数据表[数据]：" . implode(",", $backedTable) . $sqlNo;
                    }

                    if (strlen($pre) + strlen($sqlNo) + strlen($sqlTable) + strlen($outstr) + strlen($temSql) > 5242880) {
                        $file = $path . "_" . $file_n . ".sql";
                        $outstr = $file_n == 1 ? $pre . $sqlNo . $sqlTable . $outstr : $pre . $sqlNo . $outstr;
                       
                        if (!file_put_contents($file, $outstr, FILE_APPEND)) {
                            $this->error("备份文件写入失败！", url('Tools/index'));
                        }
    
                        $sqlTable = $outstr = "";
                        $backedTable = array();
                        $backedTable[] = $table;
                        $file_n++;
                        //dump($file_n);
                        //exit;
                    }
                    $outstr.=$temSql;
                }
            }
        }

        if (strlen($sqlTable . $outstr) > 0) {
            $sqlNo = "\n# Time: " . date("Y-m-d H:i:s") . "\n" .
                    "# -----------------------------------------------------------\n" .
                    "# SQLFile Label：#{$file_n}\n# -----------------------------------------------------------\n\n\n";
            if ($file_n == 1) {
                $sqlNo = "# Description:备份的数据表[结构] " . implode(",", $tables) . "\n".
                         "# Description:备份的数据表[数据] " . implode(",", $backedTable) . $sqlNo;
            } else {
                $sqlNo = "# Description:备份的数据表[数据] " . implode(",", $backedTable) . $sqlNo;
            }
            $file = $path . "_" . $file_n . ".sql";
            $outstr = $file_n == 1 ? $pre . $sqlNo . $sqlTable . $outstr : $pre . $sqlNo . $outstr;
			//exit($file);
            if (!file_put_contents($file, $outstr, FILE_APPEND)) {
                $this->error("备份文件写入失败！" ,url('Tools/index'));
            }
            $file_n++;
        }
        
        $time = time() - $time;
        exit(json_encode(array('stat'=>'ok','msg'=>"成功备份数据表，本次备份共生成了" . ($file_n-1) . "个SQL文件。耗时：{$time} 秒")));
    }

    //数据还原
    public function restore(){
        $this->assign('navmenutitle','插件管理');
        $this->assign('navmenutitlenav','数据还原');

        $size    = 0;
        $pattern = "*.sql";

        //glob() 函数返回匹配指定模式的文件名或目录。
        $filelist  = glob(UPLOAD_PATH."sqldata/".$pattern);
        $fileArray = array();

        foreach ($filelist  as $i => $file) {
            //只读取文件
            if (is_file($file)) {
                $_size       = filesize($file);
                $size        += $_size;
                $name        = basename($file);
                $pre         = substr($name, 0, strrpos($name, '_'));
                $number      = str_replace(array($pre. '_', '.sql'), array('', ''), $name);
                $fileArray[filemtime($file)] = array(
                    'time'   => filemtime($file),
                    'name'   => $name,
                    'pre'    => $pre,                    
                    'size'   => $_size,
                    'number' => $number,
                );
            }
        }

        if(empty($fileArray)) $fileArray = array();

        //按备份时间倒序排列
        krsort($fileArray); 
        $this->assign('flist', $fileArray);
        $this->assign('total', format_bytes($size));
        $this->assign('count', count($fileArray));
        return $this->fetch();
    }

    //删除sql文件
    public function delSqlFiles() {
        $table = input('post.table');
        $a = unlink(UPLOAD_PATH."sqldata". '/' . $table);

        if ($a) {
            exit(json_encode(array('stat'=>'ok','msg'=>"已删除：".$table)));
        }
    }

    //下载
    public function downFile() {
    	$gfile = input('get.file');
    	$gtype = input('get.type');

        if (empty($gfile) || empty($gtype) ) {
            exit(json_encode(array('stat'=>'on','msg'=>"下载地址错误")));
        }

        $filePath = UPLOAD_PATH."sqldata/" .input('get.file');

        if (!file_exists($filePath)) {
            exit(json_encode(array('stat'=>'on','msg'=>"该文件不存在，可能是被删除")));
        }
        $filename = basename($filePath);
        header("Content-type: application/octet-stream");
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header("Content-Length: " . filesize($filePath));
        readfile($filePath);
    }


    //执行还原数据库操作
    public function restoreData() {
        //防止备份数据过程超时
        function_exists('set_time_limit') && set_time_limit(0); 
        //取得需要导入的sql文件
        if (!isset($_SESSION['cacheRestore']['files'])) {
            $_SESSION['cacheRestore']['starttime'] = time();
            $_SESSION['cacheRestore']['files'] = $this->getRestoreFiles();
        }

        $files = $_SESSION['cacheRestore']['files'];
        if (empty($files)) {
            unset($_SESSION['cacheRestore']);
            $this->error('不存在对应的SQL文件');
        }
    
        //取得上次文件导入到sql的句柄位置
        $position = isset($_SESSION['cacheRestore']['position']) ? $_SESSION['cacheRestore']['position'] : 0;
        $execute = 0;
        foreach ($files as $fileKey => $sqlFile) {
            $file = UPLOAD_PATH."sqldata/". $sqlFile;
            if (!file_exists($file))
                continue;
            $file = fopen($file, "r");
            $sql = "";
            fseek($file, $position); //将文件指针指向上次位置
            while (!feof($file)) {
                $tem = trim(fgets($file));
                //过滤,去掉空行、注释行(#,--)
                if (empty($tem) || $tem[0] == '#' || ($tem[0] == '-' && $tem[1] == '-'))
                    continue;
                //统计一行字符串的长度
                $end = (int) (strlen($tem) - 1);
                //检测一行字符串最后有个字符是否是分号，是分号则一条sql语句结束，否则sql还有一部分在下一行中  
                if ($tem[$end] == ";") {
                    $sql .= $tem;
                    Db::execute($sql);
                    $sql = "";
                    $execute++;
                    if ($execute > 500) {
                        $_SESSION['cacheRestore']['position'] = ftell($file);
                        $imported = isset($_SESSION['cacheRestore']['imported']) ? $_SESSION['cacheRestore']['imported'] : 0;
                        $imported += $execute;
                        $_SESSION['cacheRestore']['imported'] = $imported;
                        //echo json_encode(array("status" => 1, "info" => '如果导入SQL文件卷较大(多)导入时间可能需要几分钟甚至更久，请耐心等待导入完成，导入期间请勿刷新本页，当前导入进度：<font color="red">已经导入' . $imported . '条Sql</font>', "url" => U('Database/restoreData', array(get_randomstr(5) => get_randomstr(5)))));
                        $this->success('如果SQL文件卷较大(多),则可能需要几分钟甚至更久,<br/>请耐心等待完成，<font color="red">请勿刷新本页</font>，<br/>当前导入进度：<font color="red">已经导入' . $imported . '条Sql</font>', url('Tools/restoreData', array(get_rand_str(5,0) => get_rand_str(5,0))));
                        exit();
                    }
                } else {
                    $sql .= $tem;
                }
            }
            //错误位置结束
            fclose($file);
            unset($_SESSION['cacheRestore']['files'][$fileKey]);
            $position = 0;
        }
        $time = time() - $_SESSION['cacheRestore']['starttime'];
        unset($_SESSION['cacheRestore']);
        $this->success("恢复成功，耗时：{$time} 秒钟", url('Tools/restore'));
    }

    //读取要导入的sql文件列表并排序后插入SESSION中
    private function getRestoreFiles() {
        $sqlfilepre = input('sqlfilepre','');//获取sql文件前缀

        if (empty($sqlfilepre)) {
            $this->error('请选择要还原的数据文件！');
        }
        $pattern = $sqlfilepre;
        $sqlFiles = glob(UPLOAD_PATH."sqldata/".$pattern);

        if (empty($sqlFiles)) {
            $this->error('不存在对应的SQL文件！');
        }
    
        //将要还原的sql文件按顺序组成数组，防止先导入不带表结构的sql文件
        $files = array();
        foreach ($sqlFiles as $sqlFile) {
            $sqlFile = basename($sqlFile);
            $k = str_replace(".sql", "", str_replace($sqlfilepre . "_", "", $sqlFile));
            $files[$k] = $sqlFile;
        }
        unset($sqlFiles, $sqlfilepre);
        ksort($files);
        return $files;
    }
}