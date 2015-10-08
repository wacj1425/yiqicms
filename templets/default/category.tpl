{if $category->type == "article"}						
{include file="articlecategory.tpl"}
{elseif $category->type == "product"}
{include file="productcategory.tpl"}
{/if}