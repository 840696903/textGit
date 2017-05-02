<?php
namespace Home\Controller;
use Think\Controller;
use Think\Upload;
class IndexController extends Controller {
    public function index(){
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }
    
    /**
     * 同步——上传文件
     */
    public function upload(){
        $con = array(
            "maxSize"=>0,
            "rootPath"=>"./Public/",
            "savePath"=>"",
            "autoSub"=>true,
            "subName"=>"upload",
            "saveName"=>round(0,10000)."".time(),
            "exts"=>"jpg,png,gif"   //array("jpg","png","gif")
        );
        $up = new Upload($con);
        $info = $up->uploadOne($_FILES["picture"]);
        if ($info){
            print_r($info);
            echo "上传成功";
        }else {
            echo $up->getError();
            echo "上传失败";
        }
    }
    
    /**
     * 异步——上传文件
     */
    public function upload2(){
        $con = array(
            "maxSize"=>0,
            "rootPath"=>"./Public/",
            "savePath"=>"",
            "autoSub"=>true,
            "subName"=>"upload",
            "saveName"=>round(0,10000)."".time(),
            "exts"=>"jpg,png,gif"   //array("jpg","png","gif")
        );
        $up = new Upload($con);
        $info = $up->uploadOne($_FILES["picture"]);
        if ($info){
            $this->ajaxReturn($info);
        }else {
//             $this->ajaxReturn($info);
        }
    }
}