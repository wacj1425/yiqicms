<?php
$dir = preg_replace("/[\/\\\\]{1,}/", '/', dirname(__FILE__) );

if(!file_exists($dir."/include/config.inc.php"))
{   
	header("location:install/install.php");
}
require_once 'include/common.inc.php';
if(!$tempinfo->template_exists("index.tpl"))
{
    exit("ģ�岻���ڣ�������վ��̨��������!");
}

$tempinfo->display("index.tpl");
?>