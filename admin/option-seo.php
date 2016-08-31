<?php
require_once 'admin.inc.php';
$robot_file=YIQIROOT.DIRECTORY_SEPARATOR.'robots.txt';
$robots='';
if (is_file($robot_file)) {
    $robots=file_get_contents($robot_file);
}
$action = $_POST["action"];
if($action == "save")
{
    $titlekeywords = $_POST["titlekeywords"];
    $metakeywords = $_POST["metakeywords"];
    $metadescription = $_POST["metadescription"];    
    
    if(empty($titlekeywords))
    {
        $titlekeywords="-";
    }
    if(empty($metakeywords))
    {
        $metakeywords="-";
    }
    if(empty($metadescription))
    {
        $metadescription = "-";
    }
    
    upset("titlekeywords",$titlekeywords);
    upset("metakeywords",$metakeywords);
    upset("metadescription",$metadescription);
    exit("SEO设置修改成功");
}
?>
<?php
$adminpagetitle = "SEO设置";
include("admin.header.php");?>
<div class="main_body">
<form id="sform" action="option-seo.php" method="post">
<table class="inputform" cellpadding="1" cellspacing="1">
<tr><td class="label">标题关键词</td><td class="input"><input name="titlekeywords" class="txt u-ipt" type="text" value="<?php echo getset("titlekeywords")->value;?>"  /></td></tr>
<tr><td class="label">META关键词</td><td class="input"><input name="metakeywords" class="txt u-ipt" type="text" value="<?php echo getset("metakeywords")->value;?>"  /></td></tr>
<tr>
    <td class="label">META描述</td>
    <td class="input">
        <textarea class="txt u-ipt" name="metadescription" style="width:400px;height:110px;"><?php echo getset("metadescription")->value;?></textarea>
    </td>
</tr>
<tr>
    <td class="label">robots</td>
    <td class="input">
        <textarea class="txt u-ipt" style="width:400px;height:180px;"><?php echo $robots ?></textarea>
    </td>
</tr>
<tr>
    <td class="label">生成网站地图</td>
    <td class="input">
        <select name="type">
            <option>选择网站地图格式</option>
            <option value="html">html格式</option>
            <option value="txt">txt格式</option>
            <option value="xml">xml格式</option>
        </select>　
        <a class="u-btn"　href="javascript:void(0);" id="buildmap">开始生成</a>
    </td>
</tr>
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