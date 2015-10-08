{assign var="seotitle" value=$titlekeywords}
{assign var="seokeywords" value=$metakeywords}
{assign var="seodescription" value=$metadescription}
{include file="header.tpl"}
	<!--main start-->
	<div class="main">
		<div class="mainside">
		{include file="side.tpl"}
		</div>
		<div class="mainbody">
			<div class="combox">
				<h2>公司简介</h2>				
				<div class="content">
					{$companysummary}
					<div class="fr"><a href="{formaturl type="article" siteurl=$siteurl name="about"}">更多</a></div>
				</div>
			</div>
			<div class="clear">&nbsp;</div>
			<div class="combox">
				<h2>公司动态</h2>				
				<div class="content">
					{assign var="newslist" value=$articledata->TakeArticleListByName("news",0,6)}
					{foreach from=$newslist item=newsinfo}
						<div class="result_list">
			    		<span class="fr">{$newsinfo->adddate}</span>
							<a href="{formaturl type="article" siteurl=$siteurl name=$newsinfo->filename}" title="{$newsinfo->title}" target="_blank">{$newsinfo->title}</a>
						</div>
						<div class="line"></div>
					{/foreach}
					<span class="fr"><a href="{formaturl type="category" siteurl=$siteurl name="news"}">更多</a></span>
				</div>
			</div>
			<div class="clear">&nbsp;</div>
			<div class="combox">
				<h2>最新产品</h2>				
				<div class="content">
					{assign var="productlist" value=$productdata->TakeProductList(0,0,4)}
					{foreach from=$productlist item=productinfo}
						<div class="thumb"><a href="{formaturl type="product" siteurl=$siteurl name=$productinfo->filename}" target="_blank"><img src="{$productinfo->thumb}" title="{$productinfo->name}" alt="{$productinfo->name}"/></a><br/><a href="{formaturl type="product" siteurl=$siteurl name=$productinfo->filename}" target="_blank">{$productinfo->name}</a></div>
					{/foreach}
				</div>
			</div>
		</div>
		<div class="clear">&nbsp;</div>
		<div class="combox" id="link">
				<h2>友情链接</h2>				
				<div class="content">
					{assign var="linklist" value=$linkdata->GetLinkList()}
					{foreach from=$linklist item=linkinfo}
						<a href="{$linkinfo->url}" title="{$linkinfo->title}" target="_blank">{$linkinfo->title}</a>
					{/foreach}
				</div>
			</div>
	</div>
{include file="footer.tpl"}