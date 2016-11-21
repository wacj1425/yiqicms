<?php
/**
*date:2016-08-14
*author:lvlo_master
*添加后台全局变量
*/
$host='http://'.$_SERVER["HTTP_HOST"];
$current_url=$host.$_SERVER['SCRIPT_NAME'];
$admin_url=str_replace(basename($_SERVER['SCRIPT_NAME']), '', $current_url);
/**添加后台全局变量*/
require_once '../include/common.inc.php';
require_once 'userauth.php';
function getset($varname)
{
	global $yiqi_db;
	$sql = "select * from yiqi_settings where varname = '$varname' limit 1";
	return $yiqi_db->get_row(CheckSql($sql));
}
function upset($varname,$value)
{
	global $yiqi_db;
	$sql = "update yiqi_settings set value = '$value' where varname = '$varname' limit 1";
	$yiqi_db->query(CheckSql($sql));
}
/*文件上传函数*/
function upimg(){
	    require_once("../include/upload.class.php");
	    $filedirectory = YIQIROOT."/uploads/image";
	    $filename = uniqid();
	    $filetype = $_FILES['productthumb']['type'];
		if(!in_array(strtolower($filetype),array("jpg","png","gif","image/jpeg","image/png","image/gif"))){
			exit('缩略图无效，请重新选择。');
		}
	    $upload = new Upload;
	    $upload->set_max_size(1800000); 
	    $upload->set_directory($filedirectory);
	    $upload->set_tmp_name($_FILES['productthumb']['tmp_name']);
	    $upload->set_file_size($_FILES['productthumb']['size']);
	    $upload->set_file_ext($_FILES['productthumb']['name']); 
	    $upload->set_file_type($filetype); 
	    $upload->set_file_name($filename); 	    
	    $upload->start_copy();
	    if($upload->is_ok())
	    {
	        return YIQIPATH."uploads/image/".$filename.'.'.$upload->user_file_ext;
	    }
	    else
	    {
	        exit($upload->error());
	    }
}
?>