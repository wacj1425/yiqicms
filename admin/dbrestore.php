<?php

require_once 'admin.inc.php';
require_once '../include/iam_restore.php';
require_once '../include/config.inc.php';

$action = $_POST['action'];

if($action == 'restore')
{
	if(!empty($_FILES["backupfile"]["name"]))
	{
		require_once("../include/upload.class.php");
	    $filedirectory = "../cache/";
	    $filename = date("ymdhis");
	    $filetype = $_FILES['backupfile']['type'];
	    $upload = new Upload;
	    $upload->set_max_size(1800000); 
	    $upload->set_directory($filedirectory);
	    $upload->set_tmp_name($_FILES['backupfile']['tmp_name']);
	    $upload->set_file_size($_FILES['backupfile']['size']);
	    $upload->set_file_ext($_FILES['backupfile']['name']); 
	    $upload->set_file_type($filetype); 
	    $upload->set_file_name($filename); 	    
	    $upload->start_copy(); 	    
	    if($upload->is_ok())
	    {
	        $restore = new iam_restore($upload->user_full_name, $cfg_db_host, $cfg_db_name, $cfg_db_user, $cfg_db_pass);
			$restore->perform_restore();
			unlink($upload->user_full_name);
			ShowMsg("数据恢复成功");
	    }
	    else
	    {
	        ShowMsg($upload->error());exit();
	    }
	}
}

?>
<?php
$adminpagetitle = "数据恢复";
include("admin.header.php");?>
<div class="main_body">
<form action="dbrestore.php" method="post" enctype="multipart/form-data">
<table class="inputform" cellpadding="1" cellspacing="1">
<tr><td class="label">注意事项</td><td class="input">请选择已经备份的数据,上传后执行!</td></tr>
<tr><td class="label">备份文件</td><td class="input"><input type="file" name="backupfile" /></td></tr>
<tr><td class="label"></td><td class="input">
<input type="hidden" name="action" value="restore" />
<input type="submit" class="subtn" value="马上恢复" /></td></tr>
</table>
</form>
</div>

</div>

<div class="clear">&nbsp;</div>
<?php include("admin.footer.php");?>
</div>

</body>

</html>