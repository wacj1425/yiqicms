<?php
if(!file_exists("../include/config.inc.php"))
{   
	header("location:/install/install.php");
}
require_once '../include/user.class.php';
session_start();

$uid = $_SESSION["adminid"];
$uid = (isset($uid) && is_numeric($uid)) ? $uid : 0;

$userdata = new User;
$adminuserinfo = $userdata->GetUser($uid);
if($adminuserinfo == null)
{
    exit("您没有权限执行管理,请<a href=\"login.php\">登录</a>!");    
}

if(empty($checkregular))
{
    checkauth();
}

function checkauth()
{
    global $yiqi_db;
    global $adminuserinfo;
    $pagename = end(explode("/",$_SERVER["PHP_SELF"]));
    $sql = "select * from yiqi_regular where value like '$pagename%' limit 1";
    $regularinfo = $yiqi_db->get_row(CheckSql($sql));
    $userregular = explode("|",$adminuserinfo->regular);    
    if(!checkregular($regularinfo->rid))
    {
        ShowMsg("您没有权限访问此页","back");
        exit();
    }
}

function checkregular($rid)
{
    global $adminuserinfo;
    $userregular = explode("|",$adminuserinfo->regular);    
    if(in_array($rid,$userregular))
    {
        return true;
    }
    else
    {
        return false;
    }
}
?>