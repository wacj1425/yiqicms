<?php
require_once 'include/common.inc.php';

session_start();
$action = $_POST["action"];
if($action == "save")
{
    $msgtitle = $_POST["msgtitle"];
    $msgname = $_POST["msgname"];
    $msgcontact = $_POST["msgcontact"];
    $msgcontent = htmlspecialchars($_POST["msgcontent"]);
    
    if (empty($_SESSION['captcha']) || trim(strtolower($_POST['capcode'])) != $_SESSION['captcha']) 
    {
        ShowMsg("验证码错误,请重新输入");
        exit();
    }
    
    if(!preg_match("/^.{1,30}$/",$msgtitle))
    {
        ShowMsg("请输入正确的标题");
        exit();
    }
    if(!preg_match("/^.{1,10}$/",$msgname))
    {
        ShowMsg("请输入您的姓名");
        exit();
    }
    if(!preg_match("/^.{1,20}$/",$msgcontact))
    {
        ShowMsg("请输入正确的联系方式");
        exit();
    }
    if(!preg_match("/^.{1,200}$/",$msgcontent))
    {
        ShowMsg("请输入正确的留言内容");
        exit();
    }
        
    $msgcontent = safeCheck($msgcontent);
    
    $userip = $_SERVER["REMOTE_ADDR"];;
	$sql = "INSERT INTO yiqi_comments (cid ,title ,name,contact,content,ip,adddate)" .
		   "VALUES (NULL, '$msgtitle', '$msgname', '$msgcontact','$msgcontent', '$userip', null)";
	$result = $yiqi_db->query(CheckSql($sql));
	if($result == 1)
	{
	    ShowMsg("留言添加成功");
	}
	else
	{
	    ShowMsg("留言添加失败");
	}
}
$tempinfo->display("comment.tpl");
?>