<?php
// +----------------------------------------------------------------------
// | TP5CMS 内容管理系统 微信模块 微信接口
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.gsdata.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: justin.郑 <3907721@qq.com>
// +----------------------------------------------------------------------
namespace app\wx\controller;
use think\Controller;
use think\Db;

class Api extends Controller {
    public $token = "weishi2017";
    public $website = WEB_PATH;

    public function app(){
        $this->valid();

        if(file_get_contents('php://input', 'r')){
            $postStr = file_get_contents('php://input', 'r');
            //extract post data
            if (!empty($postStr)){
                $postObj      = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername   = $postObj->ToUserName;
                $keyword      = trim($postObj->Content);
                $type         = $postObj->MsgType;
                $event        = $postObj->Event;
                $latitude     = $postObj->Location_X;
                $longitude    = $postObj->Location_Y;

                if($type=='text'){
                    //文本回复
                    $where['keyword'] = array('like',$keyword);
                    $wtfind = Db::name('WxText')->where($where)->field('keyword, content')->find();
                    if($wtfind){
                        $wxtxt = htmlspecialchars($wtfind['content']);
                        $this->response_text($wxtxt,$postObj);
                    }
                    unset($where);

                    //单图文回复
                    $where['keyword'] = array('like',$keyword);
                    $wifind  = Db::name('WxImgtext')->where($where)->field('id,keyword,title,img,url,intro')->find();
                    $wicount = Db::name('WxImgtext')->where($where)->count();
                    if($wicount == 1){
                        $tit = $wifind['title'];
                        $pic = $this->website.'/public/uploads/'.$wifind['img'];
                        $des = $wifind['intro'];
                        if($wifind['url'] != ""){
                            $url = $wifind['url'];
                        }else{
                            $url = $this->website."/Wx/Page/page/id/".$wifind['id'];
                        }
                        $this->response_one($tit,$pic,$des,$url,$postObj);
                    }
                    unset($where);

                    //多图文回复
                    $where['keyword'] = array('like',$keyword);
                    $wisfind = Db::name('WxImgs')->where($where)->find();
                    unset($where);
                    if($wisfind){
                        $ararray = explode(",", $wisfind['wid']);
                        array_pop($ararray);
                        foreach($ararray as $key){
                            $where['id'] = trim($key);
                            $itfind = Db::name('WxImgtext')->where($where)->field('id,title,img,url')->find();
                            $tit = $itfind['title'];
                            $pic = $this->website.'/public/uploads/'.$itfind['img'];
                            if($itfind['url'] != ""){
                                $url = $itfind['url'];
                            }else{
                                $url = $this->website."/Wx/Page/page/id/".$itfind['id'];
                            }
                            $res[] = array("tit"=>$tit,"pic"=>$pic,"url"=>$url);
                        }
                        return $this->response_more($res,$postObj);
                    }
                    unset($where);
                }elseif($type=="image"){        //接受图片信息
                    $wxtxt = iconv('GB2312','UTF-8','暂时不支持图片回复');
                    $this->response_text($wxtxt,$postObj);
                }elseif($type=="voice"){        //接受语音信息
                    $wxtxt = iconv('GB2312','UTF-8','暂时不支持语音回复');
                    $this->response_text($wxtxt,$postObj);
                }elseif($type=='event'){  //触发事件
                    if($event == 'subscribe'){
                        return $this->onSubscribe($postObj);        //关注返回事件
                    }elseif($event == 'CLICK'){ //点击触发事件
                        $key = $postObj->EventKey;
                        if($key){
                            $keyimg = mb_convert_encoding($key[0], "UTF-8","auto");

                            $where['keyword'] = $keyimg;
                            $wifind  = Db::name('WxImgtext')->where($where)->find();
                            $wicount = Db::name('WxImgtext')->where($where)->count();
                            unset($where);
                            if($wicount == 1){
                                $tit = $wifind['title'];
                                $pic = $this->website.'/public/uploads/'.$wifind['img'];
                                $des = $wifind['intro'];
                                if($wifind['url'] != ""){
                                    $url = $wifind['url'];
                                }else{
                                    $url = $this->website."/Wx/Page/page/id/".$wifind['id'];
                                }
                                $this->response_one($tit,$pic,$des,$url,$postObj);
                            }    //
                            //$this->response_text($keyimg,$postObj);

                            //多图文回复
                            $where['keyword'] = $keyimg;
                            $wisfind = Db::name('WxImgs')->where($where)->find();
                            unset($where);
                            if($wisfind){
                                $ararray = explode(",", $wisfind['wid']);
                                array_pop($ararray);
                                foreach($ararray as $key){
                                    $where['id'] = trim($key);
                                    $itfind = Db::name('WxImgtext')->where($where)->field('id,title,img,url')->find();
                                    $tit = $itfind['title'];
                                    $pic = $this->website.'/public/uploads/'.$itfind['img'];
                                    if($itfind['url'] != ""){
                                        $url = $itfind['url'];
                                    }else{
                                        $url = $this->website."/Wx/Page/page/id/".$itfind['id'];
                                    }
                                    $res[] = array("tit"=>$tit,"pic"=>$pic,"url"=>$url);
                                }
                                return $this->response_more($res,$postObj);
                            }
                            unset($where);
                            
                            $where['keyword'] = $keyimg;
                            $wtfind = Db::name('WxText')->where($where)->field('keyword, content')->find();
                            unset($where);
                            if($wtfind){
                                $wxtxt = htmlspecialchars($wtfind['content']);
                                $this->response_text($wxtxt,$postObj);
                            }
                        }
                    }
                }elseif($type=="location"){
                    return $this->receiveLocation($postObj);  //返回导航
                }
            }
        }
    }
    //--------------------------------------------------------------------------------
    //关注回复
    private function onSubscribe($postObj){
        $wrfind = Db::name('WxReply')->where('id',1)->find();
        return $this->response_text($wrfind['content'],$postObj);
    }
    //-----------------------------------------------------------------------------------
    //地图导航
    private function receiveLocation($postObj){
        /*$c = D("Company");
        $cfind = $c->find();
        $res[] = array("tit"=>$cfind['title'],"pic"=>'',"url"=>'');
        $res[] = array("tit"=>iconv('GB2312','UTF-8','点击查看驾车线路导航'),"pic"=>$pic,
            "url"=>"http://apis.map.qq.com/uri/v1/marker?marker=coord:".$cfind['latitude'].",".$cfind['longitude'].
            ";title:".$cfind['title'].";addr:".$cfind['address']);
        return $this->response_more($res,$postObj);
        */
    }
    //----------------------------------------------------------------------------------
    //回复文本
    public function response_text($txt,$postObj){
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $textTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[%s]]></MsgType>
        <Content>%s</Content>
        <FuncFlag>0</FuncFlag>
        </xml>";
        $res = sprintf($textTpl, $fromUsername, $toUsername, time(), "text", trim($txt));
        //Log::error($res);
        echo $res;
    }
    function response_arts($res,$postObj){
        $r = json_decode($res->con);
        if(is_array($r)){
            response_morearts($r,$res->id,$postObj);
        }else{
            response_oneart($r,$res->id,$postObj);
        }
    }
    //回复单图文
    function response_oneart($r,$rid,$postObj){
        global $wid;
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $textTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[%s]]></MsgType>
        <ArticleCount>%s</ArticleCount>
        <Articles>
        ITEM
        </Articles>
        </xml>";
        $resstr =  sprintf($textTpl, $fromUsername, $toUsername, time(), "news", 1);
        $subitem = "<item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
        </item>";
        $addpos = '?';
        if(strpos($r->ourl, '?')!==false){
            $addpos = '&';
        }
        $r->ourl = $r->ourl.$addpos.'wxid='.$fromUsername.'&wid='.$wid.'&rid='.$rid;
        $r->ourl = $r->ourl;
        $item=sprintf($subitem, $r->tit, $r->des, Conf::$http_path.$r->pic, $r->ourl);
        $resstr = str_replace('ITEM', $item, $resstr);
        echo $resstr;
    }
    //回复多图文
    function response_morearts($res,$rid,$postObj){
        global $wid;
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $textTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[%s]]></MsgType>
        <ArticleCount>%s</ArticleCount>
        <Articles>
        ITEM
        </Articles>
        </xml>";
        $resstr =  sprintf($textTpl, $fromUsername, $toUsername, time(), "news", count($res));
        $item = '';
        $subitem = "<item>
        <Title><![CDATA[%s]]></Title>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
        </item>";
        foreach ($res as $r){
            $addpos = '?';
            if(strpos($r->ourl, '?')!==false){
                $addpos = '&';
            }
            $r->ourl = $r->ourl.$addpos.'wxid='.$fromUsername.'&wid='.$wid.'&rid='.$rid;
            $r->ourl = $r->ourl;
            $item.=sprintf($subitem, $r->tit, Conf::$http_path.$r->pic, $r->ourl);
        }
        $resstr = str_replace('ITEM', $item, $resstr);
        echo $resstr;
    }
    //回复单图文内容
    function response_one($tit,$pic,$des,$url,$postObj){
        global $wid;
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $textTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[%s]]></MsgType>
        <ArticleCount>%s</ArticleCount>
        <Articles>
        ITEM
        </Articles>
        </xml>";
        $resstr =  sprintf($textTpl, $fromUsername, $toUsername, time(), "news", 1);
        $subitem = "<item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
        </item>";
        $url = $url;
        $item=sprintf($subitem, $tit, $des, $pic, $url);
        $resstr = str_replace('ITEM', $item, $resstr);
        echo $resstr;
    }
    //回复多图文
    function response_more($res,$postObj){
        global $wid;
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $textTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[%s]]></MsgType>
        <ArticleCount>%s</ArticleCount>
        <Articles>
        ITEM
        </Articles>
        </xml>";
        $resstr =  sprintf($textTpl, $fromUsername, $toUsername, time(), "news", count($res));
        $item = '';
        $subitem = "<item>
        <Title><![CDATA[%s]]></Title>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
        </item>";
        foreach ($res as $r){
            $r['url'] = $r['url'];
            $item.=sprintf($subitem, $r['tit'],$r['pic'], $r['url']);
        }
        $resstr = str_replace('ITEM', $item, $resstr);
        echo $resstr;
    }
    //------------------------------------------------------------------------------------
    //微信接口连接
    public function valid(){
        $echoStr = input('get.echostr');
        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            return true;
        }
        return false;
    }
    private function checkSignature(){
        $signature = input('get.signature');
        $timestamp = input('get.timestamp');
        $nonce     = input('get.nonce');
        $token     = $this->token;
        $tmpArr    = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr    = implode( $tmpArr );
        $tmpStr    = sha1( $tmpStr );
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
}
?>