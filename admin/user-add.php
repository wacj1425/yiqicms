<?php
require_once 'admin.inc.php';

$action = $_POST["action"];
if($action == "save")
{
    $username = $_POST["username"];
    $userpass = $_POST["userpass"];
    $confirmpass = $_POST["confirmpass"];
    $useremail = $_POST["useremail"];
    $usergender = $_POST["usergender"];
    $regular = $_POST["regular"];

    if(empty($username))
    {
        exit("用户名不能为空");
    }
    if(empty($userpass))
    {
        exit("用户密码不能为空");
    }
    if($userpass!=$confirmpass)
    {
        exit("用户密码输入不一致");
    }
    if(empty($useremail))
    {
        $useremail = "-";
    }
    if(empty($usergender))
    {
        $usergender = 0 ;
    }
    $userpass = md5($userpass);
    $nowdate = date("Y-m-d H:i:s");
    $sql = "INSERT INTO yiqi_users (uid,username,password,gender,email,regular,adddate,status) ".
           "VALUES (null,'$username','$userpass','$usergender','$useremail','".implode("|",$regular)."','$nowdate','ok')";
    $result = $yiqi_db->query(CheckSql($sql));
    if($result == 1)
    {
        exit("用户添加成功！");
    }
    else
    {
        exit("用户添加失败,请与管理员联系。");
    }
}
?>
<?php
$adminpagetitle = "添加用户";
include("admin.header.php");?>
<div class="main_body">
<form id="sform" action="user-add.php" method="post">
<table class="inputform" cellpadding="1" cellspacing="1">
<tr><td class="label">用户名称</td><td class="input"><input type="text" class="txt" name="username" /></td></tr>
<tr><td class="label">用户密码</td><td class="input"><input type="text" class="txt" name="userpass" /></td></tr>
<tr><td class="label">确认密码</td><td class="input"><input type="text" class="txt" name="confirmpass" /></td></tr>
<tr><td class="label">电子邮箱</td><td class="input"><input type="text" class="txt" name="useremail" /></td></tr>
<tr><td class="label">性别</td><td class="input"><select name="usergender"><option value="0">请选择</option><option value="1">男</option><option value="2">女</option></select></td></tr>
<tr><td class="label">权限</td><td class="input">
<?php
$regularlist = GetRegular();
if(count($regularlist)>0)
{
    foreach($regularlist as $regularinfo)
    {
        if(count($subregularlist) > 0)
        {
            echo "<div><strong class=\"clear fl\" style=\"line-height:22px;\">$regularinfo->name</strong>";
            $subregularlist = GetRegular($regularinfo->rid);
            foreach($subregularlist as $subregular)
            {
                echo "<span  class=\"regularcs\"><input id=\"regular_$subregular->rid\" name=\"regular[]\" type=\"checkbox\" value=\"$subregular->rid\"/>&nbsp;<label for=\"regular_$subregular->rid\">$subregular->name</label></span>";
            }
            echo "</div>";
        }
    }
}
?>
</td></tr>
</table>
<div class="clear">&nbsp;</div>
<div class="inputsubmit"><input type="hidden" name="action" value="save" /><input type="submit" class="subtn" value="提交" /></div>
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