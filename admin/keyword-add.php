<?php

require_once 'admin.inc.php';
require_once '../include/keywords.class.php';

$action = $_POST["action"];
if($action == "insert")
{
    $keywordname = $_POST["keywordname"];
	$keywordurl = $_POST["keywordurl"];
	$keywordorder = $_POST["keywordorder"];
	
	if(empty($keywordname))
	{
	    exit("关键词不能为空");
	}
	if(empty($keywordurl))
	{
	    exit("链接地址不能为空");
	}
	if(!is_numeric($keywordorder)||empty($keywordorder))
	{
		$keywordorder = 0;
	}

	$sql = "insert into yiqi_keywords (kid,name,url,displayorder) values (null,'$keywordname','$keywordurl','$keywordorder');";
	$result = $yiqi_db->query(CheckSql($sql));
	if($result==1)
	{
	    exit("指定关键词添加成功！");
	}
	else
	{
	    exit("关键词添加失败,请与管理员联系！");
	}
}

?>
<?php
$adminpagetitle = "添加关键词";
include("admin.header.php");?>
<div class="main_body">
<form id="sform" action="keyword-add.php" method="post">
<input id="action" type="hidden" name="action" value="insert" />
<h2>添加关键词</h2>
<table class="inputform" cellpadding="1" cellspacing="1">
<tr><td class="label">关键词</td><td class="input"><input type="text" class="txt" name="keywordname" /></td></tr>
<tr><td class="label">链接地址</td><td class="input"><input type="text" class="txt" name="keywordurl" /></td></tr>
<tr><td class="label">排序</td><td class="input"><input type="text" class="txt" name="keywordorder" /></td></tr>
</table>
<div class="clear">&nbsp;</div>
<div class="inputsubmit"><input id="submitbtn" type="submit" class="subtn" value="提交" /></div>
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
			if(msg == "指定关键词添加成功！")
				$("#sform").resetForm();
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