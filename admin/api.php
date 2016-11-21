<?php 
require_once "admin.inc.php";
/*var_dump(YIQIROOT);
die();*/
if (!isAjax()) die("Access deny!");
/*初始化网站地图生成的变量*/
$siteurl = $tempinfo->get_template_vars('siteurl');
$productlist = $productdata->GetProductList(0);
$articlelist = $articledata->GetArticleList(0);
$productcategory = $categorydata->GetCategoryList(0,"product");
$articlecategory = $categorydata->GetCategoryList(0,"article");
/*初始化地图生成的变量成功*/
define('UNIT', YIQIINC.DIRECTORY_SEPARATOR.'unit'.DIRECTORY_SEPARATOR);
$api=new Api;
$action=$_POST['action'];
$content=$_POST['content'];
$data['st']=0;
if (method_exists($api, $action)) {
	$data['str']=$api->$action($content);
	if (strlen($data['str']) > 1) {
		$data['st']=1;
	}
}else{
	$data['str']="控制器不存在";
}
die(json_encode($data));
class Api
{
	/*获点击获取关键字接口*/
	public function getKeywordsStr($content){
		require(UNIT.'analysis/phpanalysis.class.php');
		PhpAnalysis::$loadInit = false;
		$pa = new PhpAnalysis('utf-8', 'utf-8', false);
		$pa->resultType=3;
		$pa->LoadDict();
		$pa->SetSource($content);
		$pa->StartAnalysis( false );
		$tags = $pa->GetFinallyResult(',',5);
		return $tags;
	}
	/**/
	public function sitemap($content){
		switch ($content) {
			case 'html':
				$this->outputMapHtml();
				break;
			
			default:
				$this->outputMapTxt();
				break;
		}
	}
	/*输出txt网站地图*/
	public function outputMapTxt(){
		global $siteurl,$productlist,$articlelist,$productcategory,$articlecategory;
		$str='';
		foreach ($articlecategory as $v) {
			$objarr=["type" => "category","name" => "$v->filename","siteurl" => "$siteurl"];
			$str.=formaturl($objarr).PHP_EOL;
		}
		foreach ($articlelist as $v) {
			$objarr=["type" => "article","name" => "$v->filename","siteurl" => "$siteurl"];
			$str.=formaturl($objarr).PHP_EOL;
		}
		foreach ($productcategory as $v) {
			$objarr=["type" => "category","name" => "$v->filename","siteurl" => "$siteurl"];
			$str.=formaturl($objarr).PHP_EOL;
		}
		foreach ($productlist as $v) {
			$objarr=["type" => "product","name" => "$v->filename","siteurl" => "$siteurl"];
			$str.=formaturl($objarr).PHP_EOL;
		}
		file_put_contents(YIQIROOT.DIRECTORY_SEPARATOR.'sitemap.txt', $str);
		die('txt网站地图已生成');
	}
	/*输出html网站地图*/
	public function outputMapHtml(){
		global $siteurl,$productlist,$articlelist,$productcategory,$articlecategory;
		$str='
			<!DOCTYPE html>
			<html lang="zh-CN">
			<head>
				<meta charset="UTF-8">
				<title>Document</title>
			</head>
			<body>';
		foreach ($articlecategory as $v) {
			$objarr=["type" => "category","name" => "$v->filename","siteurl" => "$siteurl"];
			$str.='<a href="'.formaturl($objarr).'">'.$v->name.'<a><br/>'.PHP_EOL;
		}
		foreach ($articlelist as $v) {
			$objarr=["type" => "article","name" => "$v->filename","siteurl" => "$siteurl"];
			$str.='<a href="'.formaturl($objarr).'">'.$v->title.'<a><br/>'.PHP_EOL;
		}
		foreach ($productcategory as $v) {
			$objarr=["type" => "category","name" => "$v->filename","siteurl" => "$siteurl"];
			$str.='<a href="'.formaturl($objarr).'">'.$v->name.'<a><br/>'.PHP_EOL;
		}
		foreach ($productlist as $v) {
			$objarr=["type" => "product","name" => "$v->filename","siteurl" => "$siteurl"];
			$str.='<a href="'.formaturl($objarr).'">'.$v->name.'<a><br/>'.PHP_EOL;
		}
		$str.='</body></html>';
		file_put_contents(YIQIROOT.DIRECTORY_SEPARATOR.'sitemap.html', $str);
		die('html网站地图已生成');
	}
}