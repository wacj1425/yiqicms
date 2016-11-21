<?php
require_once 'include/common.inc.php';
require_once 'include/sitemap.class.php';

$site_map_container = new google_sitemap();

$siteurl = $tempinfo->get_template_vars('siteurl');
$productlist = $productdata->GetProductList(0);
$articlelist = $articledata->GetArticleList(0);
$productcategory = $categorydata->GetCategoryList(0,"product");
$articlecategory = $categorydata->GetCategoryList(0,"article");

//列出产品
for ( $i=0; $i < count( $productlist ); $i++ )
{
	$value = $productlist[ $i ];
	$locobj = array("type" => "product","name" => "$value->filename","siteurl" => "$siteurl");
	$loc = formaturl($locobj);
	$site_map_item = new google_sitemap_item( $loc, date("c"), 'monthly', "0.5" );
	$site_map_container->add_item( $site_map_item );
}
//列出文章
for ( $i=0; $i < count( $articlelist ); $i++ )
{
	$value = $articlelist[ $i ];
	$locobj = array("type" => "article","name" => "$value->filename","siteurl" => "$siteurl");
	$loc = formaturl($locobj);
	$site_map_item = new google_sitemap_item( $loc, date("c"), 'monthly', "0.5" );
	$site_map_container->add_item( $site_map_item );
}
//列出产品分类
for ( $i=0; $i < count( $productcategory ); $i++ )
{
	$value = $productcategory[ $i ];
	$locobj = array("type" => "category","name" => "$value->filename","siteurl" => "$siteurl");
	$loc = formaturl($locobj);
	$site_map_item = new google_sitemap_item( $loc, date("c"), 'weekly', "0.8" );
	$site_map_container->add_item( $site_map_item );
}
//列出文章分类
for ( $i=0; $i < count( $articlecategory ); $i++ )
{
	$value = $articlecategory[ $i ];
	$locobj = array("type" => "category","name" => "$value->filename","siteurl" => "$siteurl");
	$loc = formaturl($locobj);
	$site_map_item = new google_sitemap_item( $loc, date("c"), 'weekly', "0.8" );
	$site_map_container->add_item( $site_map_item );
}
//列出首页
$site_map_item = new google_sitemap_item( "$siteurl", date("c"), 'always', "1.0" );
$site_map_container->add_item( $site_map_item );

header( "Content-type: application/xml; charset=\"".$site_map_container->charset . "\"", true );

print $site_map_container->build();

?>