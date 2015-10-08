<?php
require_once 'admin.inc.php';

$action = $_POST["action"];
if($action == "save")
{
    $companyname = $_POST["companyname"];
    $companysummary = $_POST["companysummary"];
    
    if(empty($companyname))
    {
        $companyphone = getset("companyname")->value;
    }
    if(empty($companysummary))
    {
        $companysummary = getset("companysummary")->value;
    }
    
    upset("companyname",$companyname);
    upset("companysummary",$companysummary);    
    showMsg("公司资料修改成功");
}
?>
<?php
$adminpagetitle = "公司资料设置";
include("admin.header.php");?>
<div class="main_body">
<form id="sform" action="company-option.php" method="post">
<table class="inputform" cellpadding="1" cellspacing="1">
<tr><td class="label">公司名称</td><td class="input"><input type="text" class="txt" name="companyname" value="<?php echo getset("companyname")->value;?>" /></td></tr>
<tr><td class="label">公司简介<span style="color:#ff0000;">（该简介是网站首页的公司简介，如果你想修改详细的公司简介资料，请到文章管理-文章列表里面修改。）</span></td><td class="input">
<textarea id="contentform" rows="1" cols="1" style="width:580px;height:360px;" name="companysummary"><?php echo getset("companysummary")->value;?></textarea>
<!-- Load TinyMCE -->
<?php 
require_once "editor.php";
editor('kindeditor','companysummary');
 ?>
<!-- /TinyMCE -->
</td></tr>
</table>
<div class="clear">&nbsp;</div>
<div class="inputsubmit"><input type="hidden" name="action" value="save" /><input id="submitbtn" type="submit" class="subtn" value="提交" /></div>
</form>
</div>

</div>

<div class="clear">&nbsp;</div>
<?php include("admin.footer.php");?>
</div>

</body>

</html>