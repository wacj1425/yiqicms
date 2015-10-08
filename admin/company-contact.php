<?php
require_once 'admin.inc.php';

$action = $_POST["action"];
if($action == "save")
{
    $companycontact = $_POST["companycontact"];
    $companyphone = $_POST["companyphone"];
    $companymobile = $_POST["companymobile"];
    $companyfax = $_POST["companyfax"];
    $companyaddr = $_POST["companyaddr"];
    $companyemail = $_POST["companyemail"];
    $companyqq = $_POST["companyqq"];
    $companymsn = $_POST["companymsn"];
    
    if(empty($companycontact))
    {
        $companycontact = getset("companycontact")->value;
    }
    if(empty($companyphone))
    {
        $companyphone = getset("companyphone")->value;
    }
    if(empty($companymobile))
    {
        $companymobile = getset("companymobile")->value;
    }
    if(empty($companyfax))
    {
        $companyfax = getset("companyfax")->value;
    }
    if(empty($companyaddr))
    {
        $companyaddr = getset("companyaddr")->value;
    }
    if(empty($companyemail))
    {
        $companyemail = getset("companyemail")->value;
    }
    if(empty($companyurl))
    {
        $companyurl = getset("companyurl")->value;
    }
    if(empty($companyqq))
    {
        $companyqq = getset("companyqq")->value;
    }
    if(empty($companymsn))
    {
        $companymsn = getset("companymsn")->value;
    }
    
    upset("companycontact",$companycontact);
    upset("companyphone",$companyphone);
    upset("companymobile",$companymobile);
    upset("companyfax",$companyfax);
    upset("companyaddr",$companyaddr);
    upset("companyemail",$companyemail);
    upset("companyqq",$companyqq);
    upset("companymsn",$companymsn); 
    exit("联系方式修改成功");
}
?>
<?php
$adminpagetitle = "联系方式设置";
include("admin.header.php");?>
<div class="main_body">
<form id="sform" action="company-contact.php" method="post">
<table class="inputform" cellpadding="1" cellspacing="1">
<tr><td class="label">联系人</td><td class="input"><input type="text" class="txt" name="companycontact" value="<?php echo getset("companycontact")->value;?>" /></td></tr>
<tr><td class="label">联系电话</td><td class="input"><input type="text" class="txt" name="companyphone" value="<?php echo getset("companyphone")->value;?>" /></td></tr>
<tr><td class="label">移动电话</td><td class="input"><input type="text" class="txt" name="companymobile" value="<?php echo getset("companymobile")->value;?>" /></td></tr>
<tr><td class="label">传真</td><td class="input"><input type="text" class="txt" name="companyfax" value="<?php echo getset("companyfax")->value;?>" /></td></tr>
<tr><td class="label">地址</td><td class="input"><input type="text" class="txt" name="companyaddr" value="<?php echo getset("companyaddr")->value;?>" /></td></tr>
<tr><td class="label">电子邮箱</td><td class="input"><input type="text" class="txt" name="companyemail" value="<?php echo getset("companyemail")->value;?>" /></td></tr>
<tr><td class="label">QQ</td><td class="input"><input type="text" class="txt" name="companyqq" value="<?php echo getset("companyqq")->value;?>" /></td></tr>
<tr><td class="label">MSN</td><td class="input"><input type="text" class="txt" name="companymsn" value="<?php echo getset("companymsn")->value;?>" /></td></tr>
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