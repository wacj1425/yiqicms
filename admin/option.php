<?php
require_once 'admin.inc.php';
$action = $_POST["action"];
if($action == "save")
{
    $sitename = $_POST["sitename"];
    $siteurl = $_POST["siteurl"];
    $siteicp = $_POST["siteicp"];
    $sitestat = $_POST["sitestat"];
    $sitecopy = $_POST["sitecopy"];
    if(empty($sitename)) exit("请填写正确的网站名称");
    if(empty($siteurl))
    {
        $siteurl = "http://".$_SERVER["SERVER_NAME"]."/".str_replace("admin/option.php","",$_SERVER["PHP_SELF"]);
    }
    
    if(empty($siteicp))  $siteicp = "-";
    if(empty($sitestat)) $sitestat = "-"; 
    if(empty($sitecopy)) $sitecopy = "-";
    
    $redefine=json_encode(['set'=>$_POST["redefineset"],'source'=>$_POST['source'],'url'=>$_POST["redefine"]]);
    upset("redefine",$redefine);
    upset("sitename",$sitename);
    upset("siteurl",$siteurl);
    upset("siteicp",$siteicp);
    upset("sitestat",$sitestat);
    upset("sitecopy",$sitecopy);
    exit("网站设置修改成功");
}else{
    $siteurl=$_SERVER['HTTP_HOST'];
    $re_url=(strstr($siteurl,"www")) ? $siteurl : "www.".$siteurl;
    $open=$close='';
    $redefine=json_decode(getset("redefine")->value,true);
    @$redefine['set']=(in_array($redefine['set'], ['open','close'])) ? $redefine['set'] : "close";
    $$redefine['set']=' checked="checked" ';
    @$redefine['url']=(strlen($redefine['url']) > 6) ? $redefine['url'] : $re_url;
}
?>
<?php
$adminpagetitle = "网站设置";
include("admin.header.php");?>
<div class="main_body">
<form id="sform" action="option.php" method="post">
<table class="inputform" cellpadding="1" cellspacing="1">
    <tr>
        <td class="label">网站名称</td>
        <td class="input"><input type="text" class="txt u-ipt" name="sitename" value="<?php echo getset("sitename")->value;?>" /></td>
    </tr>
    <tr>
        <td class="label">网站地址</td>
        <td class="input"><input type="text" class="txt u-ipt" name="siteurl" value="<?php echo getset("siteurl")->value;?>" /></td>
    </tr>
    <tr>
        <td class="label">网站备案号</td>
        <td class="input"><input type="text" class="txt u-ipt" name="siteicp" value="<?php echo getset("siteicp")->value;?>" /></td>
    </tr>
    <tr>
        <td class="label">统计代码</td>
        <td class="input"><textarea class="txt u-ipt" name="sitestat" style="width:200px;height:110px;"><?php echo getset("sitestat")->value;?></textarea></td>
    </tr>
    <tr>
        <td class="label">版权信息</td>
        <td class="input"><textarea class="txt u-ipt" name="sitecopy" style="width:200px;height:110px;"><?php echo getset("sitecopy")->value;?></textarea></td>
    </tr>
    <tr>
        <td class="label">网站301设置</td>
        <td class="input">
            <table class="table">
                <tr>
                    <td>设置项：</td>
                    <td>
                        <input type="radio" name="redefineset" class="f-vam" <?php echo $open; ?> value="open" id="open"> <label for="open">开启重定向</label>　
                        <input type="radio" name="redefineset" class="f-vam" <?php echo $close ?> value="close" id="close"> <label for="close">关闭重定向</label>
                    </td>
                </tr>
                <tr>
                    <td>需重定向的网址：</td>
                    <td>
                        <input type="text" class="u-ipt" name="source" placeholder='例如：baidu.com'/>　
                        <span class="addinfo">注意此处只填域名</span>
                    </td>
                </tr>
                <tr>
                    <td>重定向到：</td>
                    <td>
                        <input type="text" class="u-ipt" value="<?php echo $redefine['url']; ?>" name="redefine"/>　
                        <span class="addinfo">根据网址自动生成，如有误，请修正！</span>
                    </td>
                </tr>
            </table>            
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