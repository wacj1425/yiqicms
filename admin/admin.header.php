<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $adminpagetitle;?></title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link href="../images/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../images/jq.js" ></script>
<script type="text/javascript" src="../images/yiqimenu.js" ></script>
<script type="text/javascript" src="../images/load.js" ></script>
<script type="text/javascript" src="../images/jquery.form.js"></script>
</head>

<body>

<div class="wrap">
<div class="header">
</div>
<div class="nav"><span class="fr"><img src="../images/user_icon.gif" alt="欢迎登陆" title="欢迎登陆" />&nbsp;欢迎登陆：<?php echo $adminuserinfo->username;?>&nbsp;&nbsp;您可以查看 <a href="http://www.yiqicms.com/category/changjianbangzhu/" target="_blank">易企CMS常见帮助</a>、进入 <a href="http://www.yiqicms.com/forum/" target="_blank">易企CMS论坛</a>&nbsp;或者&nbsp;<a href="logout.php">退出登录</a></span>当前位置：后台管理 》 <?php echo $adminpagetitle;?></div>
<div class="clear">&nbsp;</div>
<div class="main">

<div id="main_nav">
<?php include("menu.php"); ?>
</div>
