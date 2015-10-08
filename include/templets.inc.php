<?php
require_once 'templets.class.php';
require_once 'templets.func.php';
require_once 'article.class.php';
require_once 'product.class.php';
require_once 'link.class.php';
require_once 'category.class.php';
require_once 'navigate.class.php';
require_once 'cache.class.php';
require_once 'meta.class.php';
$tempinfo = new Templets;
$templets = $tempinfo->GetDefaultTemplets();
if($templets == null)
{
    $templets->directory = "default";    
}
$tempinfo->template_dir = YIQIROOT.'/templets/'.$templets->directory.'/';
$tempinfo->assign("templets",$templets);
$tempinfo->compile_dir = YIQIROOT.'/cache/compile/';

$sql = "select * from yiqi_settings";
$settinglist = $yiqi_db->get_results(CheckSql($sql));
if(count($settinglist)>0)
{
    foreach($settinglist as $settinginfo)
    {
        $tempinfo->assign($settinginfo->varname,$settinginfo->value);
    }
}

$categorydata = new Category;
$categorylist = $categorydata->GetSubCategory(0,"product");
$tempinfo->assign("categorylist",$categorylist);

$tempinfo->register_function("formaturl","formaturl");
$tempinfo->register_function("readrss","readrss");
//定义区域
$citys=array("zhengzhou"=>"郑州","taiyuan"=>"太原","xian"=>"西安","xinxiang"=>"新乡","xuchang"=>"许昌","jiaozuo"=>"焦作","anyang"=>"安阳","xinyang"=>"信阳", "puyang"=>"濮阳","datong"=>"大同");
$cv=$_GET['city'];
$city=$cv ? $citys[$cv] :"";
$tempinfo->assign('city',$city);
//定义区域
$articledata = new Article;
$productdata = new Product;
$categorydata = new Category;
$linkdata = new Link;
$navdata = new Navigate;
$cachedata = new Cache;
$metadata = new Meta;
$tempinfo->assign_by_ref("articledata",$articledata);
$tempinfo->assign_by_ref("productdata",$productdata);
$tempinfo->assign_by_ref("categorydata",$categorydata);
$tempinfo->assign_by_ref("linkdata",$linkdata);
$tempinfo->assign_by_ref("navdata",$navdata);
$tempinfo->assign_by_ref("metadata",$metadata);
$tempinfo->assign_by_ref("yiqi_cms_version",$cfg_yiqi_cms_version);
?>