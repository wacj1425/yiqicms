{assign var="seotitle" value=$category->seotitle}
{assign var="seokeywords" value=$category->seokeywords}
{assign var="seodescription" value=$category->seodescription}
{include file="header.tpl"}
<!--main start-->
	<div class="main">
		<div class="navigate">当前位置: <a href="{$siteurl}">首页</a> > {$category->name}</div>
		<div class="clear">&nbsp;</div>
		<div class="mainside">
		{include file="side.tpl"}
		</div>
		<div class="mainbody">			
			{if (count($subcategory) > 0)}
			{if ($curpage == 1)}
			<!--sub_category-->
			<div id="sub_category" class="combox">
				<h2>{$category->name}下的分类</h2>
				<div class="content">
					<ul>
						{foreach from=$subcategory item=cat}
						<li><a href="{formaturl type="category" siteurl=$siteurl name=$cat->filename}">{$cat->name}</a></li>				
						{/foreach}
					</ul>
				</div>
			</div>
			<!--/sub_category-->
			<div class="clear">&nbsp;</div>
			{/if}	
			{/if}
			<div class="combox" id="category">
				<div class="content">
				{if ($total > 0)}
					<div class="result_list">
					{foreach from=$productlist item=productinfo}
						<div class="thumb"><a href="{formaturl type="product" siteurl=$siteurl name=$productinfo->filename}" target="_blank"><img src="{$productinfo->thumb}" title="{$productinfo->name}" alt="{$productinfo->name}"/></a><br/><a href="{formaturl type="product" siteurl=$siteurl name=$productinfo->filename}" target="_blank">{$productinfo->name}</a></div>								
					{/foreach}
					</div>
					<div class="clear">&nbsp;</div>
					<div class="pager">
						<label>共{$total}个产品 当前{$curpage}/{$totalpage}页 </label>
						{assign var="nextpage" value="`$curpage+1`"}
						{assign var="prepage" value="`$curpage-1`"}
						<span class="fr">                
						{if ($curpage > 1)}
						<a href="{formaturl type="category" siteurl=$siteurl name=$category->filename}">首页</a>
						<a href="{formaturl type="category" siteurl=$siteurl name=$category->filename page=$prepage}">上一页</a>
						{/if}
						{if ($curpage > 0) && ($curpage < $totalpage)}
						<a href="{formaturl type="category" siteurl=$siteurl name=$category->filename page=$nextpage}">下一页</a>
						<a href="{formaturl type="category" siteurl=$siteurl name=$category->filename page=$totalpage}">尾页</a>
						{/if}               
						</span>
					</div>
				{else}
				该分类下暂时没有内容
			    {/if}
				</div>
			</div>
		</div>
	</div>
	<!--main end-->
{include file="footer.tpl"}