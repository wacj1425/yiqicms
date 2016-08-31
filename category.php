<?php
require_once 'include/common.inc.php';
require_once 'include/article.class.php';
require_once 'include/product.class.php';
require_once 'include/category.class.php';

$name = $_GET["name"];
$curpage = $_GET["p"];
var_dump($curpage);
die($name);
$curpage = (isset($curpage) && is_numeric($curpage)) ? $curpage : 1;
if($curpage<1)
{
	$curpage=1;
}
if(strpos($name,"http://")===0)
{
	header('HTTP/1.1 301 Moved Permanently');
	header("Location:".$name);
}
if(!preg_match("/^.{1,100}$/",$name))
{
    header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	exit();
}
$categorydata = new Category;
$category = $categorydata->GetCategoryByName($name);
if($category == null)
{
    header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	exit();
}
if($category->type == "article")
{
    $articledata = new Article;
    $articlecount = $articledata->GetArticleList($category->cid);
    $total = count($articlecount);
    $take = $category->takenumber;
    $skip = ($curpage - 1) * $take;
    $totalpage = (int)($total % $take == 0 ? $total / $take : $total / $take + 1);
    $articlelist = $articledata->TakeArticleList($category->cid,$skip,$take);
    $tempinfo->assign("articlelist",$articlelist);
}
else if($category->type == "product")
{
    $productdata = new Product;
    $productcount = $productdata->GetProductList($category->cid);
    $total = count($productcount);
    $take = $category->takenumber;
    $skip = ($curpage - 1) * $take;
    $totalpage = (int)($total % $take == 0 ? $total / $take : $total / $take + 1);
    $productlist = $productdata->TakeProductList($category->cid,$skip,$take);
    $tempinfo->assign("productlist",$productlist);
}
else
{
    header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	exit();
}
if($curpage > 1)
{
	$category->seotitle = $category->seotitle . ' 第'.$curpage.'页';
}
$tempinfo->assign("category",$category);
$tempinfo->assign("subcategory",$categorydata->GetSubCategory($category->cid,$category->type));

$tempinfo->assign("take",$take);
$tempinfo->assign("total",$total);
$tempinfo->assign("totalpage",$totalpage);
$tempinfo->assign("curpage",$curpage);

if(!$tempinfo->template_exists($category->templets))
{
    exit("没有找到合适的模板,请与管理员联系!");
}
$tempinfo->display($category->templets);
?>