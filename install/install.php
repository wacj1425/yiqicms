<?php
error_reporting(E_ALL ^ E_NOTICE);
header("content-type:text/html; charset=utf-8");
require_once '../include/file.class.php';

$step = $_GET["step"];

$action = $_POST["action"];
if($action == "save")
{
    $dbhost = $_POST["dbhost"];
    $dbname = $_POST["dbname"];
    $dbuser = $_POST["dbuser"];
    $dbpass = $_POST["dbpass"];
    $dbprefix = $_POST["dbprefix"];
    $adminuser = $_POST["username"];
    $adminpass = $_POST["userpass"];
    
    if(empty($dbpass))
    {
        $dbpass= "";
    }
	$sitedir = str_replace("/install/install.php","",$_SERVER["PHP_SELF"]);
	$siteurl = "http://".$_SERVER["SERVER_NAME"].$sitedir."";
    
    $link = @mysql_connect($dbhost, $dbuser, $dbpass) or die('不能连接到数据库,请确保用户名或密码正确 ');

    @mysql_query("SET NAMES UTF8;",$link);
    $db_selected = @mysql_select_db($dbname,$link) or die("指定数据库不存在");;

    $filedata = new File;
    
    $sqlcmd = $filedata->getfilesource("sql_db.sql");
	
    $sqlarr = explode("#<--break-->",$sqlcmd);	
    foreach($sqlarr as $sql)
    {
        @mysql_query(str_replace("yiqi_",$dbprefix,$sql),$link);        
    }
    $setsql = "INSERT INTO yiqi_settings(sid,varname,description,value) values (2, 'siteurl', '网站地址', '$siteurl')";
    @mysql_query(str_replace("yiqi_",$dbprefix,$setsql),$link);
    $adminsql = "INSERT INTO `yiqi_users` (`uid`, `username`, `password`, `gender`, `email`, `regular`, `adddate`, `status`) VALUES".
                "(1, '$adminuser', '".md5($adminpass)."', 1, 'admin@domain.com', '2|3|4|10|11|15|34|6|7|8|12|13|14|35|26|27|29|17|18|19|24|21|22|30|32|33|37|38|40|41|42|43|44', now(), 'ok');";
    @mysql_query(str_replace("yiqi_",$dbprefix,$adminsql),$link);
	$productsql = "INSERT INTO `yiqi_product` (`pid`, `name`, `cid`, `thumb`, `seotitle`, `seokeywords`, `seodescription`, `filename`, `content`, `adddate`, `lasteditdate`, `templets`, `viewcount`, `status`) VALUES ".
				"(1, '开源企业建站程序', 3, '" . $siteurl . "/uploads/image/product-starter.gif', '开源企业建站程序', '-', '-', 'product-starter', '<p>易企CMS是专为国内企业定制开发的开源企业建站程序,详情请登录<a href=\"http://www.yiqicms.com\">http://www.yiqicms.com</a> 查询.</p>', now(), now(), 'product.tpl', 1, 'ok');";
    @mysql_query(str_replace("yiqi_",$dbprefix,$productsql),$link);
	$productsql = "INSERT INTO `yiqi_navigate` (`navid`, `group`, `name`, `url`, `displayorder`, `status`) VALUES ".
				"(1, '顶部导航', '网站首页', '".$siteurl."/', 0, 'ok'),".
				"(2, '顶部导航', '公司介绍', '".$siteurl."/article.php?name=about', 1, 'ok'),".
				"(3, '顶部导航', '联系我们', '".$siteurl."/article.php?name=contact', 2, 'ok'),".
				"(4, '顶部导航', '在线留言', '".$siteurl."/comment.php', 3, 'ok'),".
				"(5, '次导航', '网站首页', '".$siteurl."/', 0, 'ok');";
    @mysql_query(str_replace("yiqi_",$dbprefix,$productsql),$link);
	@mysql_close($link);
    @chmod('/include',0777);
    $configsource = "<?php \n\$cfg_db_host = '$dbhost';\n\n".
                    "\$cfg_db_user = '$dbuser';\n\n".
                    "\$cfg_db_pass = '$dbpass';\n\n".
                    "\$cfg_db_name= '$dbname';\n\n".
                    "\$cfg_db_prefix = '$dbprefix';\n".
                    "\n?>";
    if(file_exists("../include/config.inc.php"))
    {
        unlink("../include/config.inc.php");
    }   
	$filedata->writefile("../include/config.inc.php",$configsource);	
    exit("<script>window.location='install.php?step=finish';</script>");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>安装向导</title>
<script type="text/javascript" src="../images/jq.js" ></script>
<link href="../images/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body
{
	
	background:url('../images/login_bg.jpg') repeat-x;
}
.wrap
{
	margin:auto;
	width:500px;
	margin-top:100px;
	color:#fff;
}
.wrap h1
{
	margin:20px 0px;
	font-size:30px;
}
.label
{
	width:100px;
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
.wrap ul li 
{
	clear:both;
	overflow:hidden;
	line-height:30px;
}
.wrap ul .title
{
	font-size:20px;
	font-weight:bold;
}
</style>
</head>

<body>

<form action="" method="post">
<div class="wrap">
<?php 
if($step == "")
{
?>
<h1>易企CMS安装向导</h1>
<ul>
<li>不会安装?点这里查看安装说明<a style="color:#ff6600;" href="http://www.yiqicms.com/article/install-guide.html" target="_blank">http://www.yiqicms.com/article/install-guide.html</a></li>
<li class="title">数据库信息</li>
<li><span class="label">数据库地址</span><span class="input"><input class="txt" type="text" name="dbhost" value="localhost"/></span></li>
<li><span class="label">数据库名称</span><span class="input"><input class="txt" type="text" name="dbname" value="yiqicms"/> 请确认数据库是否已经创建</span></li>
<li><span class="label">数据库表前缀</span><span class="input"><input class="txt" type="text" name="dbprefix" value="yiqi_"/></span></li>
<li><span class="label">数据库连接用户</span><span class="input"><input class="txt" type="text" name="dbuser" value="root"/></span></li>
<li><span class="label">数据库连接密码</span><span class="input"><input class="txt" type="text" name="dbpass" value=""/></span></li>
<li class="title">管理员信息</li>
<li><span class="label">管理员名称</span><span class="input"><input class="txt" type="text" name="username" value="admin" /></span></li>
<li><span class="label">管理员密码</span><span class="input"><input class="txt" type="text" name="userpass" value="yiqi" /></span></li>
<li><span class="label">&nbsp;</span><span class="input"><input type="hidden" name="action" value="save"/><input class="btn" type="submit"  value="安装" /></span></li>
</ul>
<?php 
}
else if($step ==  "finish")
{
?>
<h1>安装完成</h1>
恭喜,易企CMS已经成功安装! 为了更方便的使用易企CMS，请先阅读 <a href="http://www.yiqicms.com/category/changjianbangzhu/" style="color:#ff0000;" target="_blank">易企CMS常见帮助。</a><br/>
您还可以:<a href="../" style="color:red;">返回前台</a> 或 <a style="color:red;" href="../admin/login.php">进入后台</a><br/>
<h3 style="color:red">重要:为了安全起见,请删除install目录，防止数据丢失!</h3>
<script type="text/javascript" src="http://www.yiqicms.com/update/installinit.php"></script>
<?php
unlink("install.php");
}
?>
</div>
</form>
</body>

</html>