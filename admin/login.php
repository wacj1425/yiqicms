<?php
require_once '../include/common.inc.php';
require_once '../include/user.class.php';

session_start();
$action = $_POST["action"];
if($action=="save")
{
    $username = $_POST["username"];
    $userpass = $_POST["password"];    
    
	if(function_exists("imagejpeg"))
	{
		if (empty($_SESSION['captcha']) || trim(strtolower($_POST['capcode'])) != $_SESSION['captcha'])    
		{
			ShowMsg("验证码错误,请重新输入");
			exit();
		}
	}
    $userdata = new User;
    $existuser = $userdata->ExistUserPassword($username,$userpass);
    if($existuser == 1)
    {
        $userinfo = $userdata->GetUserByName($username);
        session_start();
        $_SESSION["adminid"] = $userinfo->uid;
        header("location:index.php");
    }
    else
    {
    	ShowMsg("用户名或密码错误");exit();
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>用户登录</title>
<script type="text/javascript" src="../images/jq.js" ></script>
<link href="../images/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body
{
	
	background:url('../images/login_bg.jpg') repeat-x;
}
.login
{
	margin:auto;
	width:500px;
	margin-top:200px;
	color:#fff;
}
.label
{
	width:80px;
	float:left;
}
.input
{
	float:left;
}
.txt
{
	width:200px;
	height:20px;
	line-height:20px;
}
.btn
{
	padding:5px 20px;
}
.login ul li 
{
	clear:both;
	overflow:hidden;
	line-height:30px;
}
</style>
</head>

<body>
<form action="" method="post">
<div class="login">
<ul>
<li><span class="label">用户名</span><span class="input"><input class="txt" type="text" name="username" /></span></li>
<li><span class="label">密码</span><span class="input"><input class="txt" type="password" name="password"/></span></li>
<?php 
if(function_exists("imagejpeg"))
{ 
	echo '<li><span class="label">验证码</span><span class="input"><input class="txt" type="text" name="capcode" style="width:60px;"/>&nbsp;<img style="cursor:pointer" src="../captcha/captcha.php" onclick="$(this).attr(\'src\',\'../captcha/captcha.php?d=\'+Date())" /></span></li>';
}?>
<li><span class="label">&nbsp;</span><span class="input"><input type="hidden" name="action" value="save"/><input class="btn" type="submit" value="提交" /></span></li>
<li><span class="label">&nbsp;</span><span class="input">忘记密码？<a style="color:#ff0000;font-weight:bold;" href="http://www.yiqicms.com/article/%E6%98%93%E4%BC%81CMS%E9%87%8D%E8%AE%BE%E7%AE%A1%E7%90%86%E5%AF%86%E7%A0%81%E5%B7%A5%E5%85%B7.html" target="_blank">点这里</a></span></li>
</ul>
</div>
</form>
</body>

</html>
