<?php
require_once 'admin.inc.php';

$sql = "select * from yiqi_settings";
$settinglist = $yiqi_db->get_results(CheckSql($sql));

$sid = $_GET["sid"];

if(!is_numeric($sid))
	$sid = 0;
$action = $_POST["action"];
if($sid > 0)
{
	$sql = "select * from yiqi_settings where sid = '$sid'";
	$setinfo = $yiqi_db->get_row(CheckSql($sql));
	if($setinfo==null)
		header("location:settings.php");
}
if($action == "save")
{
    $varname = $_POST["varname"];
    $vardescription = $_POST["vardescription"];
    $varvalue = $_POST["varvalue"];
    
    if(empty($varname))
    {
        exit("请填写正确的变量名称");
    }
    if(empty($vardescription))
    {
        $vardescription = "-";
    }
    if(empty($varvalue))
    {
        $varvalue = "-";
    }
	if($sid>0)
	{
		$sql = "update yiqi_settings set `varname`='$varname',`description`='$vardescription',`value`='$varvalue' WHERE `sid` = '$sid' limit 1";
	}
	else
	{
		$sql = "INSERT INTO yiqi_settings (`sid`,`varname`,`description`,`value`) VALUES (NULL,'$varname','$vardescription','$varvalue');";
	}
	$yiqi_db->query(CheckSql($sql));
    exit("变量设置成功");
}
else if($action == "delete")
{
	if($setinfo!=null)
	{
		$sql = "DELETE FROM yiqi_settings WHERE `sid` = '$sid' limit 1";
		$yiqi_db->query(CheckSql($sql));
	}
	exit("指定变量删除成功");
}
?>
<?php
$adminpagetitle = "网站变量管理";
include("admin.header.php");?>
<div class="main_body">
<form id="sform" action="" method="post">
<table class="inputform" cellpadding="1" cellspacing="1">
<tr><td class="label">选择变量</td><td class="input">
<select id="varid" name="varlist">
<option value="0">增加新变量</option>
<?php
if(count($settinglist)>0)
{
    foreach($settinglist as $settinginfo)
    {
		if($setinfo->sid == $settinginfo->sid)
		{
			echo "<option selected='selected' value=\"".$settinginfo->sid."\">".$settinginfo->varname.'('.$settinginfo->description.')'."</option>";
		}
		else
		{
			echo "<option value=\"".$settinginfo->sid."\">".$settinginfo->varname.'('.$settinginfo->description.')'."</option>";
		}
    }
}
?></select>
　　<?php if($sid>0){ ?> <a id="delink" href="javascript:void(0);">删除变量</a> <?php } ?>
</td></tr>
<tr><td class="label">变量名称</td><td class="input"><input type="text" class="txt" name="varname" value="<?php echo $setinfo->varname;?>" />&nbsp;此项在模板调用,调用方式{$变量名称}（<span style="color:#ff0000;font-weight:bold;">值必需为英文或数字</span>）</td></tr>
<tr><td class="label">变量描述</td><td class="input"><input type="text" class="txt" name="vardescription" value="<?php echo $setinfo->description;?>" /></td></tr>
<tr><td class="label">变量值</td><td class="input"><textarea class="txt" name="varvalue" style="width:300px;height:110px;"><?php echo $setinfo->value;?></textarea></td></tr>
</table>
<div class="clear">&nbsp;</div>
<div class="inputsubmit"><input type="hidden" id="action" name="action" value="save" /><input id="submitbtn" type="submit" class="subtn" value="提交" /></div>
</form>
</div>

</div>
<script type="text/javascript">
$(function(){
	var formoptions = {
		beforeSubmit: function() {
			$("#submitbtn").val("正在处理...");
			$("#submitbtn").attr("disabled","disabled");
		},
		success: function (msg) {
			alert(msg);
			$("#submitbtn").val("提交");
			$("#submitbtn").attr("disabled","");
			if(msg =="变量设置成功" || msg=="指定变量删除成功")
				window.location.href = 'settings.php';
		}
	};
	$("#sform").ajaxForm(formoptions);
	$("#varid").change(function(){
		window.location.href= 'settings.php?sid='+$(this).val();
	});
	$("#delink").click(function(){
		if(confirm("确认删除选中的变量?"))
		{
			$("#action").val("delete");
			setTimeout(form_submit,1);
		}
	});
});
function form_submit()
{
	$("#sform").trigger("submit");
}
</script>
<div class="clear">&nbsp;</div>
<?php include("admin.footer.php");?>
</div>

</body>

</html>