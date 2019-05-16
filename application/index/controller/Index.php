<?php
namespace app\index\controller;
use QL\QueryList;
use think\Controller;
class Index extends Controller
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ad_bd568ce7058a1091"></think>';
    }


    public function homepage(){
    	$url='https://www.mzitu.com';
    	$rules=[
    		'detail'=>['#pins>li>a','href'],
    		'face'=>['#pins>li>a>img','data-original'],
    		'alt'=>['#pins>li>a>img','alt'],
    	];
    	$data = QueryList::get($url)->rules($rules)->query()->getData();

    	$rt=$data->map(function($item){
    		$item['count'] = $this->detail($item['detail']);
    		return $item;
    	})->all();

    	// echo '<pre>';
    	// var_dump($rt);
    	// echo '</pre>';
    	$this->assign('list',$rt);

    	return $this->fetch();
    }

    /*获取详情页数*/
    public function detail($url='https://www.mzitu.com/178724'){
    	$rules=[
    		'pagenavi'=>['.pagenavi','text']
    	];
    	$rt = QueryList::get($url,[
    		'headers'=>[
    			'Referer'=>$url,
    		]
    	])
    	->rules($rules)->query()->getData()->all();
    	return $this->cut('…','下一页',$rt[0]['pagenavi']);
    }

    //截取指定两个字符之间的字符串
	public function cut($begin,$end,$str){
	    $b = mb_strpos($str,$begin) + mb_strlen($begin);
	    $e = mb_strpos($str,$end) - $b;
	    return mb_substr($str,$b,$e);
	}
}
