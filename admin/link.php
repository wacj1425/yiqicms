<?php
require_once 'admin.inc.php';
require_once '../include/link.class.php';
$curpage=$_GET["p"];
$curpage = (isset($curpage) && is_numeric($curpage)) ? $curpage : 1;
if($curpage<1)
{
	$curpage=1;
}
$linkdata = new Link;
$linkcount = $linkdata->GetLinkList();
$total = count($linkcount);
$take = 20;
$skip = ($curpage - 1) * $take;
$totalpage = (int)($total % $take == 0 ? $total / $take : $total / $take + 1);
$linklist = $linkdata->TakeLinkList($skip,$take);

$action = $_POST["action"];
if($action == "update")
{
    $idarr = $_POST["chk"];
	if(count($idarr) > 0)
	{
		foreach($idarr as $id)
		{
			$title=$_POST["title"];
			$url=$_POST["url"];
			$order=$_POST["order"];
			if(is_numeric($id))
			{
				$sql = "update yiqi_link set title='".$title[$id]."',url='".$url[$id]."',displayorder='".$order[$id]."' WHERE lid = '$id' limit 1";
				$yiqi_db->query(CheckSql($sql));
			}
		}
		ShowMsg("指定链接更新成功");
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
				$sql = "DELETE FROM yiqi_link WHERE lid = '$id' limit 1";
				$yiqi_db->query(CheckSql($sql));
			}
		}
		ShowMsg("指定链接删除成功");
	}
}
else if($action == "insert")
{
    $linktitle = $_POST["linktitle"];
	$linkurl = $_POST["linkurl"];
	$linkorder = $_POST["linkorder"];
	$linkremark = $_POST["linkremark"];
	if(empty($linktitle))
	{
	    exit("链接名称不能为空");
	}
	if(empty($linkurl))
	{
	    exit("链接地址不能为空");
	}
	if(!is_numeric($linkorder)||empty($linkorder))
	{
		$linkorder = 0;
	}
	if(empty($linkremark))
	{
		$linkremark = "-";
	}
	$curdate=date('YmdHis');
	$sql = "insert into yiqi_link (lid,title,url,remark,displayorder,adddate,status) values (null,'$linktitle','$linkurl','$linkremark','$linkorder','$curdate','ok');";
	$result = $yiqi_db->query(CheckSql($sql));
	if($result==1)
	{
	    exit("指定链接添加成功！");
	}
	else
	{
	    exit("链接添加失败,请与管理员联系！");
	}
}
?>
<?php
$adminpagetitle = "友情链接管理";
include("admin.header.php");?>
<div class="main_body">
<form action="link.php" method="post">
<table class="inputform" cellpadding="1" cellspacing="1">
<tr style="background:#f6f6f6;"><td class="w10">选择</td><td class="w30">链接标题</td><td class="w30">链接地址</td><td class="w10">排序</td><td class="w20">备注</td></tr>
<?php
if(count($linklist)>0)
{
    foreach($linklist as $linkinfo)
    {
       echo "<tr>".
            "<td><input id=\"slt$linkinfo->lid\" type=\"checkbox\" name=\"chk[]\" value=\"$linkinfo->lid\" /></td>".
       		"<td><input type=\"text\" class=\"txt\" style=\"width:120px;\" name=\"title[$linkinfo->lid]\" value=\"$linkinfo->title\" /></td>".
            "<td><input type=\"text\" class=\"txt\" style=\"width:120px;\" name=\"url[$linkinfo->lid]\" value=\"$linkinfo->url\" /></td>".
            "<td><input type=\"text\" class=\"txt\" style=\"width:50px;\" name=\"order[$linkinfo->lid]\" value=\"$linkinfo->displayorder\" /></td>".
       		"<td>$linkinfo->remark</td>".
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
echo "共${total}个链接 当前${curpage}/${totalpage}页 ";
if($curpage > 1)
{
    echo "<a href=\"link.php?p=1\">首页</a>".
		 "&nbsp;<a href=\"link.php?p=".($curpage-1)."\">上一页</a>";
}
if($curpage > 0 && $curpage < $totalpage)
{
    echo "&nbsp;<a href=\"link.php?p=".($curpage+1)."\">下一页</a>".
    	 "&nbsp;<a href=\"link.php?p=$totalpage\">尾页</a>";
}
?>
</div>
</form>
<div class="clear">&nbsp;</div>
<form id="sform" action="link.php" method="post">
<input id="action" type="hidden" name="action" value="updated" />
<h2>添加友情链接</h2>
<table class="inputform" cellpadding="1" cellspacing="1">
<tr><td class="label">链接名称</td><td class="input"><input type="text" class="txt" name="linktitle" /></td></tr>
<tr><td class="label">链接地址</td><td class="input"><input type="text" class="txt" name="linkurl" value="http://" /></td></tr>
<tr><td class="label">排序</td><td class="input"><input type="text" class="txt" name="linkorder" /></td></tr>
<tr><td class="label">备注</td><td class="input"><textarea class="txt" name="linkremark" style="width:200px;height:110px;"></textarea></td></tr>
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
			if(msg == "指定链接添加成功！")
				window.location.href = 'link.php';
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