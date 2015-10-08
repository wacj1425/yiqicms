<?php
require_once 'include/common.inc.php';
require_once 'include/article.class.php';
require_once 'include/keywords.class.php';
session_start();
$name=$_GET["name"];
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

$tempinfo->assign("article",$article);

if(!$tempinfo->template_exists($article->templets))
{
    exit("没有找到合适的模板,请与管理员联系!");
}
$articledata->UpdateCount($article->aid);
$tempinfo->display($article->templets);
?>