<?php
require_once 'admin.inc.php';
require_once '../include/comments.class.php';

$curpage=$_GET["p"];
$curpage = (isset($curpage) && is_numeric($curpage)) ? $curpage : 1;
if($curpage<1)
{
	$curpage=1;
}
$commentdata = new Comments;
$commentcount = $commentdata->GetCommentsList();
$total = count($commentcount);
$take = 20;
$skip = ($curpage - 1) * $take;
$totalpage = (int)($total % $take == 0 ? $total / $take : $total / $take + 1);
$commentlist = $commentdata->TakeCommentsList($skip,$take);
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
				$sql = "DELETE FROM yiqi_comments WHERE cid = '$id' limit 1";
				$yiqi_db->query(CheckSql($sql));
			}
		}
		ShowMsg("指定留言删除成功");
	}
}
?>
<?php
$adminpagetitle = "留言列表";
include("admin.header.php");?>
<div class="main_body">
<form action="comments.php" method="post">
<table class="inputform" cellpadding="1" cellspacing="1">
<tr style="background:#f6f6f6;"><td class="w10"></td><td class="w20">标题</td><td class="w20">留言人姓名</td><td class="w20">联系方式</td><td class="w20">留言时间</td><td class="w10">相关操作</td></tr>
<?php
if(count($commentlist)>0)
{
    foreach($commentlist as $comment)
    {
       echo "<tr>".
			"<td><input id=\"slt$comment->cid\" type=\"checkbox\" name=\"chk[]\" value=\"$comment->cid\" /></td>".
       		"<td><a href=\"comment-info.php?cid=$comment->cid\">$comment->title</a></td>".
            "<td>$comment->name</td>".
            "<td>$comment->contact</td>".
       		"<td>$comment->adddate</td>".
       		"<td><a href=\"comment-info.php?cid=$comment->cid\">查看</a></td>".
       		"</tr>";
    } 
}
?>
</table>
<div class="clear">&nbsp;</div>
<div class="fl" style="text-indent:16px;"><input id="slt" type="checkbox"/>&nbsp;&nbsp;<select name="action"><option value="-">批量应用</option><option value="delete">删除</option></select>&nbsp;<input type="submit" class="subtn" value="提交" onclick="if(!confirm('确认执行相应操作?')) return false;"/></div>
<div class="fr">
<?php 
$_SERVER["QUERY_STRING"] = preg_replace("/(&)?p=[0-9]{1,3}(&)?/","",$_SERVER["QUERY_STRING"]);
echo "共${total}条留言 当前${curpage}/${totalpage}页 ";
if($curpage > 1)
{
    echo "<a href=\"comments.php?p=1\">首页</a>".
		 "&nbsp;<a href=\"comments.php?p=".($curpage-1)."\">上一页</a>";
}
if($curpage > 0 && $curpage < $totalpage)
{
    echo "&nbsp;<a href=\"comments.php?p=".($curpage+1)."\">下一页</a>".
    	 "&nbsp;<a href=\"comments.php?p=$totalpage\">尾页</a>";
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