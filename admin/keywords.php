<?php
require_once 'admin.inc.php';
require_once '../include/keywords.class.php';
$curpage=$_GET["p"];
$curpage = (isset($curpage) && is_numeric($curpage)) ? $curpage : 1;
if($curpage<1)
{
	$curpage=1;
}

$searchkey = $_POST["searchkey"];

$keywhere = "";
if($searchkey != "")
{
	$keywhere="where name like '%$searchkey%'";
}

$keywordsdata = new Keywords;
$keywordscount = $keywordsdata->GetKeywordsList($keywhere);
$total = count($keywordscount);
$take = 20;
$skip = ($curpage - 1) * $take;
$totalpage = (int)($total % $take == 0 ? $total / $take : $total / $take + 1);
$keywordslist = $keywordsdata->TakeKeywordsList($skip,$take,$keywhere);


$action = $_POST["action"];
if($action == "update")
{
    $idarr = $_POST["chk"];
	if(count($idarr) > 0)
	{
		foreach($idarr as $id)
		{
			$name=$_POST["name"];
			$url=$_POST["url"];
			$order=$_POST["order"];
			if(is_numeric($id))
			{
				$sql = "update yiqi_keywords set name='".$name[$id]."',url='".$url[$id]."',displayorder='".$order[$id]."' WHERE kid = '$id' limit 1";
				$yiqi_db->query(CheckSql($sql));
			}
		}
		ShowMsg("指定关键词更新成功");
	}
}
else if($action == "delete")
{
    $idarr = $_POST["chk"];
	if(count($idarr) > 0)
	{
		foreach($idarr as $id)
		{
			if(is_numeric($id))
			{
				$sql = "DELETE FROM yiqi_keywords WHERE kid = '$id' limit 1";
				$yiqi_db->query(CheckSql($sql));
			}
		}
		ShowMsg("指定关键词删除成功");
	}
}

?>
<?php
$adminpagetitle = "关键词管理";
include("admin.header.php");?>
<div class="main_body">
<form action="keywords.php" method="post">
<table class="inputform" cellpadding="1" cellspacing="1">
<tr><td class="label">关键词搜索</td><td class="input"><input type="text" class="txt" name="searchkey" value="<?php echo $searchkey;?>" /></td></tr>
<tr><td class="label">&nbsp;</td><td class="input"><input type="submit" class="subtn" value="搜索"/></td></tr>
</table>
</form>
<div class="clear">&nbsp;</div>
<form action="keywords.php" method="post">
<input id="action" type="hidden" name="action" value="update" />
<table class="inputform" cellpadding="1" cellspacing="1">
<tr style="background:#f6f6f6;"><td class="w10">选择</td><td class="w40">关键词</td><td class="w40">链接地址</td><td class="w10">排序</td></tr>
<?php
if(count($keywordslist)>0)
{
    foreach($keywordslist as $keywordsinfo)
    {
       echo "<tr>".
            "<td><input id=\"slt$keywordsinfo->kid\" type=\"checkbox\" name=\"chk[]\" value=\"$keywordsinfo->kid\" /></td>".
       		"<td><input type=\"text\" class=\"txt\" style=\"width:120px;\" name=\"name[$keywordsinfo->kid]\" value=\"$keywordsinfo->name\" /></td>".
            "<td><input type=\"text\" class=\"txt\" style=\"width:120px;\" name=\"url[$keywordsinfo->kid]\" value=\"$keywordsinfo->url\" /></td>".
            "<td><input type=\"text\" class=\"txt\" style=\"width:50px;\" name=\"order[$keywordsinfo->kid]\" value=\"$keywordsinfo->displayorder\" /></td>".       		
       		"</tr>";
    } 
}
?>
</table>
<div class="clear">&nbsp;</div>
<div class="fl" style="text-indent:16px;"><input id="slt" type="checkbox"/>&nbsp;&nbsp;<select name="action"><option value="-">批量应用</option><option value="update">更新</option><option value="delete">删除</option></select>&nbsp;<input type="submit" class="subtn" value="提交" onclick="if(!confirm('确认执行相应操作?')) return false;"/></div>
<div class="fr">
<?php 
$_SERVER["QUERY_STRING"] = preg_replace("/(&)?p=[0-9]{1,3}(&)?/","",$_SERVER["QUERY_STRING"]);
echo "共${total}个关键词 当前${curpage}/${totalpage}页 ";
if($curpage > 1)
{
    echo "<a href=\"keywords.php?p=1\">首页</a>".
		 "&nbsp;<a href=\"keywords.php?p=".($curpage-1)."\">上一页</a>";
}
if($curpage > 0 && $curpage < $totalpage)
{
    echo "&nbsp;<a href=\"keywords.php?p=".($curpage+1)."\">下一页</a>".
    	 "&nbsp;<a href=\"keywords.php?p=$totalpage\">尾页</a>";
}
?>
</div>
</form>
</div>

</div>

<div class="clear">&nbsp;</div>
<?php include("admin.footer.php");?>
</div>

</body>

</html>