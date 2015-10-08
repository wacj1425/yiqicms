<?php
require_once 'admin.inc.php';
require_once '../include/category.class.php';

$categorydata = new Category;

$type = $_GET["type"];
if(empty($type) || $type=='')
{
    $type="article";
}
$action = $_POST["action"];
if($action == "delete")
{
    $idarr = $_POST["chk"];
	if(count($idarr) > 0)
	{
		foreach($idarr as $id)
		{
			if(is_numeric($id))
			{
				$sql = "DELETE FROM yiqi_category WHERE cid = '$id' limit 1";
				$yiqi_db->query(CheckSql($sql));
			}
		}
		ShowMsg("指定分类删除成功");
	}
}
elseif($action == "update")
{
	$idarr = $_POST["chk"];
	if(count($idarr) > 0)
	{
		foreach($idarr as $id)
		{
			$order=$_POST["order"];
			if(is_numeric($id))
			{
				$sql = "update yiqi_category set displayorder = '".$order[$id]."' WHERE cid = '$id' limit 1";
				$yiqi_db->query(CheckSql($sql));
			}
		}
		ShowMsg("指定分类更新成功");
	}
}
?>
<?php
$adminpagetitle = "分类列表";
include("admin.header.php");?>
<div class="main_body">
<form action="" method="post">
<table class="inputform" cellpadding="1" cellspacing="1">
<tr style="background:#f6f6f6;"><td class="w10">选择</td><td class="w10">分类ID</td><td class="w50">分类名称</td><td class="w10">排序</td><td class="w20">相关操作</td></tr>
<?php
$categorylist = $categorydata->GetCategoryList(0,$type);
if(count($categorylist) > 0)
{
    foreach($categorylist as $category)
    {
        echo "<tr>".			
            "<td><input id=\"slt$category->cid\" type=\"checkbox\" name=\"chk[]\" value=\"$category->cid\" /></td>".
			"<td>$category->cid</td>".
			"<td><a href=\"../category.php?name=".urlencode($category->filename)."\" target=\"_blank\">$category->name</a></td>".
        	"<td><input type=\"text\" class=\"txt\" style=\"width:50px;\" name=\"order[$category->cid]\" value=\"$category->displayorder\" /></td>".
            "<td><a href=\"category-add.php?pid=$category->cid\">添加子分类</a> <a href=\"category-edit.php?cid=$category->cid\">编辑</a>  <a href=\"category-move.php?cid=$category->cid\">移动</a></td>";
    }
}
?>
</table>
<div class="clear">&nbsp;</div>
<div class="fl" style="text-indent:16px;"><input id="slt" type="checkbox"/>&nbsp;&nbsp;<select name="action"><option value="-">批量应用</option><option value="delete">删除</option><option value="update">更新</option></select>&nbsp;<input type="submit" class="subtn" value="提交" onclick="if(!confirm('确认执行相应操作?')) return false;"/></div>
</form>
</div>

</div>

<div class="clear">&nbsp;</div>
<?php include("admin.footer.php");?>
</div>

</body>

</html>