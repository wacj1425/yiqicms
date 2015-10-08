			<div class="combox">
				<h2>产品目录</h2>
				<div class="content">
					<ul>
						{if (count($categorylist) > 0)}
						{foreach from=$categorylist item=categoryinfo}
						<li><a href="{formaturl type="category" siteurl=$siteurl name=$categoryinfo->filename}">{$categoryinfo->name}</a></li>
						{/foreach}
						{else}
						<li>暂无分类</li>
						{/if}
					</ul>
				</div>
			</div>
			<div class="clear">&nbsp;</div>
			<div class="combox">
				<h2>联系我们</h2>
				<div class="content">
					<ul>
						{if $companyqq != "" && $companyqq != "-"}
						<li>QQ:{$companyqq}</li>
						{/if}
						{if $companyphone != "" && $companyphone != "-"}
						<li>电话:{$companyphone}</li>
						{/if}
						{if $companyemail != "" && $companyemail != "-"}
						<li>电子邮箱:{$companyemail}</li>
						{/if}
						{if $companyaddr != "" && $companyaddr != "-"}
						<li>地址:{$companyaddr}</li>
						{/if}
						<li><span class="fr"><a href="{formaturl type="article" siteurl=$siteurl name="contact"}">更多</a></span></li>
					</ul>
				</div>
			</div>