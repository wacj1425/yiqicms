<?php
require_once 'admin.inc.php';
require_once '../include/user.class.php';
$curpage=$_GET["p"];
$curpage = (isset($curpage) && is_numeric($curpage)) ? $curpage : 1;
if($curpage<1)
{
	$curpage=1;
}
$userdata = new User;
$usercount = $userdata->GetUserList();
$total = count($usercount);
$take = 20;
$skip = ($curpage - 1) * $take;
$totalpage = (int)($total % $take == 0 ? $total / $take : $total / $take + 1);
$userlist = $userdata->TakeUserList($skip,$take);
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
				$sql = "DELETE FROM yiqi_users WHERE uid = '$id' limit 1";
				$yiqi_db->query(CheckSql($sql));
			}
		}
		ShowMsg("指定用户删除成功");
	}
}
?>
<?php
$adminpagetitle = "用户列表";
include("admin.header.php");?>
<div class="main_body">
<form action="users.php" method="post">
<table class="inputform" cellpadding="1" cellspacing="1">
<tr style="background:#f6f6f6;"><td class="w10">选择</td><td class="w30">用户名称</td><td class="w20">性别</td><td class="w20">电子邮箱</td><td class="w20">相关操作</td></tr>
<?php
if(count($userlist)>0)
{
    foreach($userlist as $userinfo)
    {
        $usergender = "男";
        if($userinfo->gender == 2)
        {
            $usergender = "女";
        }
        else if($userinfo->gender == 1)
        {
            $usergender = "男";
        }
        else if($userinfo->gender == 0)
        {
            $usergender = "未知";
        }
       echo "<tr>".
            "<td><input id=\"slt$userinfo->uid\" type=\"checkbox\" name=\"chk[]\" value=\"$userinfo->uid\" /></td>".
       		"<td>$userinfo->username</td>".
            "<td>$usergender</td>".
            "<td>$userinfo->email</td>".
       		"<td><a href=\"user-profile.php?uid=$userinfo->uid\">查看</a></td>".
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
echo "共${total}个用户 当前${curpage}/${totalpage}页 ";
if($curpage > 1)
{
    echo "<a href=\"users.php?p=1\">首页</a>".
		 "&nbsp;<a href=\"users.php?p=".($curpage-1)."\">上一页</a>";
}
if($curpage > 0 && $curpage < $totalpage)
{
    echo "&nbsp;<a href=\"users.php?p=".($curpage+1)."\">下一页</a>".
    	 "&nbsp;<a href=\"users.php?p=$totalpage\">尾页</a>";
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