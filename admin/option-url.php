<?php
require_once 'admin.inc.php';
require_once '../include/file.class.php';

$action = $_POST["action"];
if($action == "save")
{
    $filedata = new File;
    $urlrewrite = $_POST['url'];
    @chmod(YIQIROOT,0755);
    if($urlrewrite == "true" || $urlrewrite == "html")
    {
        $htacc = "<IfModule mod_rewrite.c>\n".
        		 "RewriteEngine On\n".
        		 "RewriteBase ".YIQIPATH."\n".
                 "RewriteCond %{REQUEST_FILENAME} !-f\n".
                 "RewriteCond %{REQUEST_FILENAME} !-d\n".
                 "RewriteRule ^article\/(.+)\.html$ article.php?name=$1 [L]\n".
                 "RewriteRule ^product\/(.+)\.html$ product.php?name=$1 [L]\n".
                 "RewriteRule ^category\/([^/_]+)[/]?$ category.php?name=$1 [L]\n".
				 "RewriteRule ^category\/([^/]+)_([0-9]+)[/]?$ category.php?name=$1&p=$2 [L]\n".                 
                 "RewriteRule ^comment.html$ comment.php [L]\n".
				 "RewriteRule ^sitemap.xml$ sitemap.php [L]\n".
                 "</IfModule>";        
        $filedata->writefile("../.htaccess",$htacc);
    }
    else
    {
        $urlrewrite = "false";
        @unlink("../.htaccess");
    }
    upset("urlrewrite",$urlrewrite);
    exit("URL设置修改成功");
}
?>
<?php
$adminpagetitle = "URL设置";
include("admin.header.php");?>
<div class="main_body">
<form id="sform" action="option-url.php" method="post">
<table class="inputform" cellpadding="1" cellspacing="1">
<tr><td class="label"><input name="url" type="radio" value="false"/>关闭URL重写</td><td class="input">链接样式: /article.php?name=abc</td></tr>
<tr><td class="label"><input name="url" type="radio" value="true" />开启URL重写</td><td class="input">链接样式: /article/abc.html</td></tr>
<tr><td class="label"><input name="url" type="radio" value="html"/>生成HTML</td><td class="input">链接样式: /article/abc.html，发布文章或产品时将会自动生成HTML文件。</td></tr>
<tr><td class="label">URL重写提示：</a><td class="input" style="color:#ff0000;">如果您开启URL重写之后，无法正常打开网页，请参考 <a href="http://www.yiqicms.com/article/url-rewrite-guide.html" target="_blank">URL重写（伪静态）指南</a></td></tr>
</table>
<div class="clear">&nbsp;</div>
<div class="inputsubmit"><input type="hidden" name="action" value="save" /><input id="submitbtn" type="submit" class="subtn" value="提交" /></div>
</form>
</div>
</div>

<div class="clear">&nbsp;</div>
<?php include("admin.footer.php");?>
</div>
<script type="text/javascript">
$(function(){
    $("input[name='url']").each(function(){
    	if($(this).val() == "<?php echo getset("urlrewrite")->value;?>")
    	{
    		$(this).attr("checked","checked");
    	}
    });
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
</body>

</html>