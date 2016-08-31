<?php 
require_once "admin.inc.php";
if (!isAjax()) die("Access deny!");
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
}