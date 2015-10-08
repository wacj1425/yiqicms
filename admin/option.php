<?php
require_once 'admin.inc.php';

$action = $_POST["action"];
if($action == "save")
{
    $sitename = $_POST["sitename"];
    $siteurl = $_POST["siteurl"];
    $siteicp = $_POST["siteicp"];
    $sitestat = $_POST["sitestat"];
    $sitecopy = $_POST["sitecopy"];
    
    if(empty($sitename))
    {
        exit("请填写正确的网站名称");
    }
    if(empty($siteurl))
    {
        $siteurl = "http://".$_SERVER["SERVER_NAME"]."/".str_replace("admin/option.php","",$_SERVER["PHP_SELF"]);
    }
    if(empty($siteicp))
    {
        $siteicp = "-";
    }
    if(empty($sitestat))
    {
        $sitestat = "-";
    }
    if(empty($sitecopy))
    {
        $sitecopy = "-";
    }
    
    upset("sitename",$sitename);
    upset("siteurl",$siteurl);
    upset("siteicp",$siteicp);
    upset("sitestat",$sitestat);
    upset("sitecopy",$sitecopy);
    exit("网站设置修改成功");
}
?>
<?php
$adminpagetitle = "网站设置";
include("admin.header.php");?>
<div class="main_body">
<form id="sform" action="option.php" method="post">
<table class="inputform" cellpadding="1" cellspacing="1">
<tr><td class="label">网站名称</td><td class="input"><input type="text" class="txt" name="sitename" value="<?php echo getset("sitename")->value;?>" /></td></tr>
<tr><td class="label">网站地址</td><td class="input"><input type="text" class="txt" name="siteurl" value="<?php echo getset("siteurl")->value;?>" /></td></tr>
<tr><td class="label">网站备案号</td><td class="input"><input type="text" class="txt" name="siteicp" value="<?php echo getset("siteicp")->value;?>" /></td></tr>
<tr><td class="label">统计代码</td><td class="input"><textarea class="txt" name="sitestat" style="width:200px;height:110px;"><?php echo getset("sitestat")->value;?></textarea></td></tr>
<tr><td class="label">版权信息</td><td class="input"><textarea class="txt" name="sitecopy" style="width:200px;height:110px;"><?php echo getset("sitecopy")->value;?></textarea></td></tr>
</table>
<div class="clear">&nbsp;</div>
<div class="inputsubmit"><input type="hidden" name="action" value="save" /><input id="submitbtn" type="submit" class="subtn" value="提交" /></div>
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
		}
	};
	$("#sform").ajaxForm(formoptions);
});
</script>
<div class="clear">&nbsp;</div>
<?php include("admin.footer.php");?>
</div>

</body>

</html>