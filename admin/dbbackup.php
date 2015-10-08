<?php
require_once 'admin.inc.php';
require_once '../include/iam_backup.php';
require_once '../include/config.inc.php';

$action = $_POST['action'];
if($action == 'backup')
{
	$backup = new iam_backup($cfg_db_host, $cfg_db_name,$cfg_db_user,$cfg_db_pass, false, true, true);	
	$backup->perform_backup();
	exit();
}
?>

<?php
$adminpagetitle = "数据备份";
include("admin.header.php");?>
<div class="main_body">
<form action="dbbackup.php" method="post">
<table class="inputform" cellpadding="1" cellspacing="1">
<tr><td class="label">注意事项</td><td class="input">所有数据将以下载的形式备份,请妥善保存!<br />该备份方式只适合于小型数据备份<span style="color:#ff0000;">(50M以下)</span>，如果您的数据库较大，请使用phpmyadmin或帝国备份王备份。</td></tr>
<tr><td class="label"></td><td class="input">
<input type="hidden" name="action" value="backup" />
<input type="submit" class="subtn" value="马上备份" /></td></tr>
</table>
</form>
</div>

</div>

<div class="clear">&nbsp;</div>
<?php include("admin.footer.php");?>
</div>

</body>

</html>