<?php
// +----------------------------------------------------------------------
// | TP5CMS 内容管理系统 后台管理 单元类
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.gsdata.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: justin.郑 <3907721@qq.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\model\WxDiymenu as WxDiymenuModel;
use think\Db;

class WxDiymenu extends Base{
    public function index(){
    	$this->assign('navmenutitle','微信基础管理');
        $this->assign('navmenutitlenav','微信菜单管理');

        $wdlist = WxDiymenuModel::where('pid',0)->order('ordernum desc')->select();

        foreach($wdlist as $key=>$vo){
            $c = WxDiymenuModel::where(array('pid'=>$vo['id']))->order('ordernum desc')->select();
            $wdlist[$key]['list']=$c;
        }

        $this->assign('count',count($wdlist));
        $this->assign('wdlist',$wdlist);

        return $this->fetch();
    }

    //添加
    public function add(){
        $wdlist = WxDiymenuModel::where('pid',0)->order('ordernum desc')->select();
        $this->assign('wdlist',$wdlist);
    	return $this->fetch();
    }

    //插入
    public function insert(){
    	$result = WxDiymenuModel::create(input('post.'));
    	if($result){
    		return showApiJson(200,'成功');
    	}else{
    		return showApiJson(400,'失败');
    	}
    }

    //编辑
    public function edit(){
        $wdlist = WxDiymenuModel::where('pid',0)->order('ordernum desc')->select();
        $this->assign('wdlist',$wdlist);

    	$wdfind = WxDiymenuModel::get(input('get.id'));
    	$this->assign('wdfind',$wdfind);
    	return $this->fetch();
    }

    //修改
    public function update(){
        $result = WxDiymenuModel::update(input('post.'));
        if($result){
            return showApiJson(200,'成功');
        }else{
            return showApiJson(400,'失败');
        }   
    }

    //启动
    public function status(){
    	$result = WxDiymenuModel::get(input('post.id'));
    	if(input('post.status') == 0){
    		$result->status = 1;
    	}elseif(input('post.status') == 1){
    		$result->status = 0;
    	}

    	if (false !== $result->save()) {
			return showApiJson(200,'成功');
		}
    }

    //删除
    public function delete(){
        $did = input('post.did/a');
        if(is_array($did)){
        	$id = implode(',',$did);
            $result = WxDiymenuModel::destroy($id);
            if($result){			 
                return showApiJson(200,'成功');
            }else{
                return showApiJson(400,'失败');
            }
        }else if(!empty($did)){
            $result = WxDiymenuModel::destroy($did);
            if($result){			 
                return showApiJson(200,'成功');
            }else{
                return showApiJson(400,'失败');
            }
        }else{
            return showApiJson(400,'失败');
        }
    }

    //生成自定义DIY菜单
    public function diymenu_send(){
        if($this->webCon()->wxappid && $this->webCon()->wxappsecret){
            $appid = $this->webCon()->wxappid;
            $appsecret = $this->webCon()->wxappsecret;
        }else{
            $this->error('必须先填写【AppId】【AppSecret】'); exit;
        }       
        //$api = Db::name('WxDiymenu')->where(array('token'=>$_SESSION['token']))->find();
        $url_get='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
        $json=json_decode($this->curlGet($url_get));
        //dump($json);

        $data = '{"button":[';
        $class = Db::name('WxDiymenu')->where(array('status'=>1,'pid'=>0))->limit(3)->order('ordernum desc')->select();

        $kcount = Db::name('WxDiymenu')->where(array('status'=>1,'pid'=>0))->limit(3)->order('ordernum desc')->count();
        $k=1;

        foreach($class as $key=>$vo){
            //主菜单
            $data.='{"name":"'.$vo['title'].'",';

            $c = Db::name('WxDiymenu')->where(array('status'=>1,'pid'=>$vo['id']))->limit(5)->order('ordernum desc')->select();
            $count = Db::name('WxDiymenu')->where(array('status'=>1,'pid'=>$vo['id']))->limit(5)->order('ordernum desc')->count();

            //子菜单
            if($c!=false){
                $data.='"sub_button":[';
            }else{
                if($vo['url']){
                    $data.='"type":"view","url":"'.$vo['url'].'"';
                }else{
                    $data.='"type":"click","key":"'.$vo['title'].'",';
                }
            }
            $i=1;
            foreach($c as $voo){
                if($i==$count){
                    if($voo['url']){
                        $data.='{"type":"view","name":"'.$voo['title'].'","url":"'.$voo['url'].'"}';
                    }else{
                        $data.='{"type":"click","name":"'.$voo['title'].'","key":"'.$voo['keyword'].'"}';
                    }
                }else{
                    if($voo['url']){
                        $data.='{"type":"view","name":"'.$voo['title'].'","url":"'.$voo['url'].'"},';
                    }else{
                        $data.='{"type":"click","name":"'.$voo['title'].'","key":"'.$voo['keyword'].'"},';
                    }
                }
                $i++;
            }
            if($c!=false){
                $data.=']';
            }

            if($k==$kcount){
                $data.='}';
            }else{
                $data.='},';
            }
            $k++;
        }
        $data.=']}';

        file_get_contents('https://api.weixin.qq.com/cgi-bin/menu/delete?access_token='.$json->access_token);
        $url='https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$json->access_token;

        if($this->api_notice_increment($url,$data)==false){
            return showApiJson(400,'失败');
        }else{
            return showApiJson(200,'成功');
        }
        exit;
    }

    
}