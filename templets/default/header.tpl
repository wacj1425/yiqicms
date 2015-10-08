<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>{$seotitle} - {$sitename}</title>
{if $seokeywords != "-" && $seokeywords != ""}
<meta name="keywords" content="{$seokeywords}" />
{/if}
{if $seodescription != "-" && $seodescription != ""}
<meta name="description" content="{$seodescription}" />
{/if}
<meta name="generator" content="YiqiCMS {$yiqi_cms_version}" />
<meta name="author" content="YiqiCMS Team!" />
<meta name="copyright" content="copyright 2009-2010 YiqiCMS.com all rights reserved." />
<script type="text/javascript" src="{$siteurl}/images/jq.js"></script>
<link href="{$siteurl}/templets/{$templets->directory}/images/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="wrap">
	<!--header start-->
	<div class="header">
		<div class="logo"><a href="{$siteurl}"><img src="{$siteurl}/templets/{$templets->directory}/images/logo.gif"/></a></div>
	</div>
	<!--menu end-->
	<div class="menu">
		<ul>
			{assign var="topnavlist" value=$navdata->TakeNavigateList("顶部导航",0,10)}
			{foreach from=$topnavlist item=navinfo}
				<li><a href="{$navinfo->url}" title="{$navinfo->name}">{$navinfo->name}</a></li>
			{/foreach}
		</ul>
	</div>
	<!--menu end-->
	<div class="clear">&nbsp;</div>
	<div class="slider"><img src="{$siteurl}/templets/{$templets->directory}/images/banner.jpg" alt="" title="" /> </div>
	<!--header end-->
	<div class="clear">&nbsp;</div>
