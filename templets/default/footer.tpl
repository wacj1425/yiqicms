	<div class="clear">&nbsp;</div>
	<!--footer start-->
	<div class="footer">
		<div class="fl">
		{assign var="footnavlist" value=$navdata->TakeNavigateList("次导航",0,10)}
		{foreach from=$footnavlist item=navinfo}
			<a href="{$navinfo->url}" title="{$navinfo->name}">{$navinfo->name}</a>
		{/foreach}
		{$sitecopy} Powered by <a href="http://www.yiqicms.com/" target="_blank">YiqiCMS</a>-<a href="http://www.seowhy.com/" target="_blank">SEOWHY</a></div>
		{if $siteicp != "-" && $siteicp != ""}
		<div class="fr">{$siteicp}</div>
		{/if}
		<div style="display:none">{$sitestat}</div>
	</div>
	<!--footer end--></div>

</body>

</html>
