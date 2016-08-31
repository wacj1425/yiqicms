<?php
require_once 'include/common.inc.php';
require_once 'include/article.class.php';
require_once 'include/keywords.class.php';
session_start();
$name=$_GET["name"];
$page=(@$_GET['p'] && (@$_GET["p"] > 0)) ? @$_GET['p'] : 1;
if(strpos($name,"http://")===0)
{
	header('HTTP/1.1 301 Moved Permanently');
	header("Location:".$name);
}
if(!preg_match("/^.{1,100}$/",$name))
{
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
}

$uid = $_SESSION["adminid"];
$uid = (isset($uid) && is_numeric($uid)) ? $uid : 0;

$cururl = "http://".$_SERVER["HTTP_HOST"]. $_SERVER["REQUEST_URI"];
$article = null;
if($uid > 0)
{
	$article = $articledata->GetArticleByName($name,true);
}
else
{
	$article = $articledata->GetArticleByName($name,false);
}
if($article == null)
{
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
}
$article->content = mixkeyword($article->content);

$siteurl=$tempinfo->_tpl_vars['siteurl'];
/*分页部分代码*/
$content_arr=explode('{!--page--}', $article->content);
$total=count($content_arr);
$page= ($page<=$total) ? $page : $total;
$article->content=$content_arr[$page-1];
if ($total>1) {
	$article->pageinfo=pages();
}else{
	$article->pageinfo='';
}
/*分页部分结束*/
$tempinfo->assign("article",$article);

if(!$tempinfo->template_exists($article->templets))
{
    exit("没有找到合适的模板,请与管理员联系!");
}
$articledata->UpdateCount($article->aid);
$tempinfo->display($article->templets);

function urlStr($page=1){
	global $siteurl,$name;
	return formaturl(['siteurl'=>$siteurl.'/','type'=>'article','name'=>$name,'page'=>$page]);
}
function pages(){
	global $total,$page;
	$str='';
	for ($i=1; $i <= $total; $i++) { 
		$link_str='<a href='.urlStr($i).'>'.$i.'</a>';
		if ($i==$page) {
			$link_str='<a href="javascript:void" class="current">'.$i.'</a>';
		}
		$str.=$link_str;
	}
	return $str;
}
?>