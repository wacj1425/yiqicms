<?php

define("YIQIINC",preg_replace("/[\/\\\\]{1,}/i", '/', dirname(__FILE__) ));
define("YIQIROOT",preg_replace("/[\/\\\\]{1,}/i", '/', substr(YIQIINC,0,-8) ));
define("YIQIPATH", str_replace(GetRootPath(), "", YIQIROOT.'/'));
define("BASE_URL",'http://'.$_SERVER["HTTP_HOST"].YIQIPATH);
header("content-type:text/html; charset=utf-8");
error_reporting(E_ALL ^ E_NOTICE);

require_once 'common.func.php';
require_once 'data.class.php';
require_once 'templets.inc.php';
require_once 'version.php';
if(phpversion() > '5.1.0')
    date_default_timezone_set('Asia/Shanghai');

function GetRootPath()
{
	$sRealPath = realpath('.');
	$sSelfPath = $_SERVER['PHP_SELF'];
	$sSelfPath = substr( $sSelfPath, 0, strrpos($sSelfPath, '/'));
	return preg_replace("/[\/\\\\]{1,}/i", '/',substr( $sRealPath, 0, strlen($sRealPath) - strlen($sSelfPath)));
}
?>