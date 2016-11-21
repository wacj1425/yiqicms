<?php
require_once 'admin.inc.php';
require_once '../include/category.class.php';

$cid = $_GET["cid"];
$cid = (isset($cid) && is_numeric($cid)) ? $cid : 0;

$categorydata = new Category;

$catinfo = $categorydata->GetCategory($cid);
if(!empty($catinfo->type))
{
    $type = $catinfo->type;
}
if(empty($type) || $type == '')
{
    $type = "article";
}

$action = $_POST["action"];
if($action == "save")
{
    $sid = $_POST["sourcecategory"];
    $tid = $_POST["targetcategory"];
    $tid = (isset($tid) && is_numeric($tid)) ? $tid : -1;
	$sid = (isset($sid) && is_numeric($sid)) ? $sid : 0;
    if($sid == 0)
    {
        exit("请选择正确的原始分类");
    }
    if($tid == -1)
    {
        exit("请选择正确的目标分类");
    }
    if($sid == $tid)
    {
        exit("原始分类不能和目标分类一致");
    }
    $sql = "UPDATE yiqi_category SET pid = '$tid' WHERE cid = '$sid'";
    $result = $yiqi_db->query(CheckSql($sql));
    if($result == 1)
    {
        exit("移动分类成功");
    }
}
?>
<?php
$adminpagetitle = "移动分类";
include("admin.header.php");?>
<div class="main_body">
<form id="sform" action="" method="post">
<table class="inputform" cellpadding="1" cellspacing="1">
<tr><td class="label">原始分类</td><td class="input"><select name="sourcecategory">
<?php
$categorylist = $categorydata->GetCategoryList(0,$type);
foreach($categorylist as $category)
{
    if($cid == $category->cid)
    {
	    echo "<option value=\"".$category->cid."\" selected=\"selected\">".$category->name."</option>";
    }
    else
    {
        echo "<option value=\"".$category->cid."\">".$category->name."</option>";
    }
}
?></select></td></tr>
<tr><td class="label">目标分类</td><td class="input"><select name="targetcategory">
<option value="0">设为顶级分类</option>
<?php
$categorylist = $categorydata->GetCategoryList(0,$type);
foreach($categorylist as $category)
{
    echo "<option value=\"".$category->cid."\">".$category->name."</option>";
}
?>
</select></td></tr>
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