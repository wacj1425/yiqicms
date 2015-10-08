{assign var="seotitle" value="在线留言"}
{include file="header.tpl"}
	<!--main start-->
	<div class="main">
		<div class="combox">
			<h2>在线留言</h2>
			<div class="content">
				<form action="{$siteurl}/comment.php" method="post">
				<table style="width:100%;line-height:30px;height:30px;">
					<tr><td class="w20">留言标题</td><td><input type="text" name="msgtitle" value="我对贵公司产品感兴趣"/></td></tr>
					<tr><td class="w20">您的姓名</td><td><input type="text" name="msgname"/></td></tr>
					<tr><td class="w20">联系方式</td><td><input type="text" name="msgcontact"/></td></tr>
					<tr><td class="w20">留言内容</td><td><textarea name="msgcontent" rows="10" cols="30"></textarea></td></tr>
					<tr><td class="w20">验证码</td><td><input type="text" name="capcode" style="width:80px;"/>&nbsp;<img style="cursor:pointer" src="{$siteurl}/captcha/captcha.php" onclick="$(this).attr('src','{$siteurl}/captcha/captcha.php?d='+Date())" /></td></tr>
					<tr><td class="w20">&nbsp;</td><td><input type="hidden" name="action" value="save"/><input type="submit" value="提交" /></td></tr>
				</table>
				</form>
			</div>
		</div>		
	</div>
	<!--main end-->
{include file="footer.tpl"}