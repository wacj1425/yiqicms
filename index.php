<?php
$dir = preg_replace("/[\/\\\\]{1,}/", '/', dirname(__FILE__) );

if(!file_exists($dir."/include/config.inc.php"))
{   
	header("location:install/install.php");
}
require_once 'include/common.inc.php';
if(!$tempinfo->template_exists("index.tpl"))
{
    exit("模板不存在，请在网站后台重新设置!");
}

$tempinfo->display("index.tpl");
?>