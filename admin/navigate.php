<?php
require_once 'admin.inc.php';
require_once '../include/navigate.class.php';
$curpage=$_GET["p"];
$curpage = (isset($curpage) && is_numeric($curpage)) ? $curpage : 1;
if($curpage<1)
{
	$curpage=1;
}
$siteconfig = getset("siteurl");
$navdata = new Navigate();
$navcount = $navdata->GetNavigateList();
$total = count($navcount);
$take = 20;
$skip = ($curpage - 1) * $take;
$totalpage = (int)($total % $take == 0 ? $total / $take : $total / $take + 1);
$navlist = $navdata->TakeNavigateList(false,$skip,$take);

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
			$group=$_POST["group"];
			if(is_numeric($id))
			{
				$sql = "update yiqi_navigate set `name`='".$name[$id]."',`url`='".$url[$id]."',`displayorder`='".$order[$id]."',`group`='".$group[$id]."' WHERE `navid` = '$id' limit 1";
				$yiqi_db->query(CheckSql($sql));
			}
		}
		ShowMsg("指定导航更新成功");
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
				$sql = "DELETE FROM yiqi_navigate WHERE navid = '$id' limit 1";
				$yiqi_db->query(CheckSql($sql));
			}
		}
		ShowMsg("指定导航删除成功");
	}
}
else if($action == "insert")
{
    $navname = $_POST["navname"];
	$navurl = $_POST["navurl"];
	$navorder = $_POST["navorder"];
	$navgroup = $_POST["navgroup"];
	if(empty($navname))
	{
	    exit("导航名称不能为空");
	}
	if(empty($navurl))
	{
	    exit("导航地址不能为空");
	}
	if(!is_numeric($navorder)||empty($navorder))
	{
		$navorder = 0;
	}
	$navurl = str_replace("{siteurl}",$siteconfig->value,$navurl);
	if(empty($navgroup))
	{
		exit("请填写导航所属分组");
	}
	$sql = "INSERT INTO yiqi_navigate (`navid`,`name`,`url`,`group`,`displayorder`,`status`) VALUES (null,'$navname','$navurl','$navgroup','$navorder','ok');";
	$result = $yiqi_db->query(CheckSql($sql));
	if($result==1)
	{
	    exit("指定导航添加成功！");
	}
	else
	{
	    exit("导航添加失败,请与管理员联系！");
	}
}
?>
<?php
$adminpagetitle = "导航管理";
include("admin.header.php");?>
<div class="main_body">
<form action="navigate.php" method="post">
<table class="inputform" cellpadding="1" cellspacing="1">
<tr style="background:#f6f6f6;"><td class="w10">选择</td><td class="w20">链接标题</td><td class="w40">链接地址</td><td class="w10">排序</td><td class="w20">所属分组</td></tr>
<?php
if(count($navlist)>0)
{
    foreach($navlist as $navinfo)
    {
       echo "<tr>".
            "<td><input id=\"slt$navinfo->navid\" type=\"checkbox\" name=\"chk[]\" value=\"$navinfo->navid\" /></td>".
       		"<td><input type=\"text\" class=\"txt u-ipt\" style=\"width:120px;\" name=\"name[$navinfo->navid]\" value=\"$navinfo->name\" /></td>".
            "<td><input type=\"text\" class=\"txt u-ipt\" style=\"width:260px;\" name=\"url[$navinfo->navid]\" value=\"$navinfo->url\" /></td>".
            "<td><input type=\"text\" class=\"txt u-ipt\" style=\"width:50px;\" name=\"order[$navinfo->navid]\" value=\"$navinfo->displayorder\" /></td>".
       		"<td><input type=\"text\" class=\"txt u-ipt\" style=\"width:80px;\" name=\"group[$navinfo->navid]\" value=\"$navinfo->group\" /></td>".
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
echo "共${total}个导航 当前${curpage}/${totalpage}页 ";
if($curpage > 1)
{
    echo "<a href=\"navigate.php?p=1\">首页</a>".
		 "&nbsp;<a href=\"navigate.php?p=".($curpage-1)."\">上一页</a>";
}
if($curpage > 0 && $curpage < $totalpage)
{
    echo "&nbsp;<a href=\"navigate.php?p=".($curpage+1)."\">下一页</a>".
    	 "&nbsp;<a href=\"navigate.php?p=$totalpage\">尾页</a>";
}
?>
</div>
</form>
<div class="clear">&nbsp;</div>
<form id="sform" action="navigate.php" method="post">
<input id="action" type="hidden" name="action" value="updated" />
<h3>添加导航</h3>
<table class="inputform" cellpadding="1" cellspacing="1">
<tr><td class="label">链接标题</td><td class="input"><input type="text" class="txt u-ipt" name="navname" /></td></tr>
<tr><td class="label">链接地址</td><td class="input"><input type="text" class="txt u-ipt" name="navurl" value="{siteurl}/" /> 注：{siteurl}=网站地址=<?php echo getset("siteurl")->value; ?></td></tr>
<tr><td class="label">排序</td><td class="input"><input type="text" class="txt u-ipt" name="navorder" /></td></tr>
<tr><td class="label">所属分组</td><td class="input"><input type="text" class="txt u-ipt" name="navgroup" /></td></tr>
</table>
<div class="clear">&nbsp;</div>
<div class="inputsubmit"><input id="submitbtn" type="submit" class="subtn" value="提交"  onclick="$('#action').val('insert');" /></div>
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
			if(msg == "指定导航添加成功！")
				window.location.href = 'navigate.php';
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