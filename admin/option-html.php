<?php
require_once 'admin.inc.php';
require_once '../include/article.class.php';
require_once '../include/product.class.php';
require_once '../include/category.class.php';
require_once '../include/file.class.php';

$siteurl = getset("siteurl")->value;
$gt = $_GET['gt'];
$all = $_GET['all'];
$ids = $_GET['ids'];
$action = $_POST["action"];
if($action == "save")
{
	$genehtml = getset("urlrewrite")->value;
	if ( $genehtml != "html" ) {
		ShowMsg("您还没有开启生成HTML选项，请到左侧“URL重写”设置选项里面开启！");
	}
	$type = $_POST['genoption'];
	switch($type) {
		case 'all':
			redirect("?all=true&gt=home");
			break;
		default:
		case 'home':
			redirect("?gt=home");
			break;
		case 'article':
			redirect("?gt=article");
			break;
		case 'product':
			redirect("?gt=product");
			break;
		case 'category':
			redirect("?gt=category");
			break;
		case 'maps':
			redirect("?gt=maps");
			break;
	}
}

switch($gt) {

	case "home":
		chmod(YIQIROOT."/",0777);
		$htmlmsg = "正在生成 首页...";
		$source = $tempinfo->fetch("index.tpl");
		$cachedata->WriteFileCache(YIQIROOT.'/'.'index.html', $source, true);
		if ( $all == "true" )
			redirect("?all=true&gt=article");
		else 
			$htmlmsg = "生成HTML完成.";
		break;
	case "article":
		chmod(YIQIROOT."/article/",0777);
		$articlelist = $articledata->GetArticleList(0);
		$articlecount = count($articlelist);
		if ( !$ids )
			$ids = 1;
		if ( $ids <= $articlecount ) {
			$article = $articlelist[ $ids-1 ];
			$htmlmsg = "共 $articlecount 篇文章，正在生成第 $ids 篇...";
			$tempinfo->assign("article",$article);
			$source = $tempinfo->fetch($article->templets);
			$urlparam = array( 'name' => $article->filename, 'type' => 'article', 'generatehtml' => 1 );
			$fileurl = formaturl($urlparam);
			$cachedata->WriteFileCache(YIQIROOT.'/'.$fileurl, $source, true);
			$alltrue = $all =="true" ? "all=true&" : '';
			$nextlink = "?".$alltrue."gt=article&ids=".($ids+1);
			redirect("".$nextlink);
		} elseif ($all == "true") {
			redirect("?all=true&gt=product");
		} else {
			$htmlmsg = "生成HTML完成.";
		}
		break;
	case "product":
		chmod(YIQIROOT."/product/",0777);
		$productlist = $productdata->GetProductList(0);
		$productcount = count($productlist);
		if ( !$ids )
			$ids = 1;
		if ( $ids <= $productcount ) {
			$product = $productlist[ $ids-1 ];
			$htmlmsg = "共 $productcount 产品，正在生成第 $ids 个...";
			$tempinfo->assign("product",$product);
			$source = $tempinfo->fetch($product->templets);
			$urlparam = array( 'name' => $product->filename, 'type' => 'product', 'generatehtml' => 1 );
			$fileurl = formaturl($urlparam);
			$cachedata->WriteFileCache(YIQIROOT.'/'.$fileurl, $source, true);
			$alltrue = $all =="true" ? "all=true&" : '';
			$nextlink = "?".$alltrue."gt=product&ids=".($ids+1);
			redirect("".$nextlink);
		} elseif ($all == "true") {
			redirect("?all=true&gt=category");
		} else {
			$htmlmsg = "生成HTML完成.";
		}
		break;
	case "category":
		chmod(YIQIROOT."/category/",0777);
		$sql = "SELECT * from yiqi_category";
		$categorylist = $yiqi_db->get_results(CheckSql($sql));
		$categorycount = count($categorylist);
		if ( !$ids )
			$ids = 1;
		if ( $ids <= $categorycount ) {
			$curpage = $_GET['page'];
			if( $curpage < 1)
				$curpage=1;
			
			$alltrue = $all =="true" ? "all=true&" : '';			
			$htmlmsg = "共 $categorycount 分类，正在生成第 $ids 个, 第 $curpage 页...";
			
			$category = $categorylist[ $ids-1 ];
			$source = getcategorysource($category, $curpage);
			$total = $source['totalpage'];

			$urlparam = array( 'name' => $category->filename, 'type' => 'category', 'generatehtml' => 1, 'page'=> $curpage );
			$fileurl = formaturl($urlparam);
			$cachedata->WriteFileCache(YIQIROOT.'/'.$fileurl.'index.html', $source['source'], true);
			if( $total > $curpage ) {
				$curpage = ($curpage+1);
				$nextlink = "?".$alltrue."gt=category&ids=".$ids."&page=".$curpage;
				redirect("".$nextlink);
			} else {
				$nextlink = "?".$alltrue."gt=category&ids=".($ids+1);
				redirect("".$nextlink);
			}
		} elseif ($all == "true") {
			redirect("?all=true&gt=maps");
		}else {
			$htmlmsg = "生成HTML完成.";
		}
		break;
	case "maps":
		chmod(YIQIROOT."/",0777);
		$htmlmsg = "正在生成 网站地图、留言页...";
		$mapsource = file_get_contents($siteurl.'/sitemap.php');
		$cachedata->WriteFileCache(YIQIROOT.'/'.$fileurl.'sitemap.xml', $mapsource, true);
		$commentsource = $tempinfo->fetch("comment.tpl");
		$cachedata->WriteFileCache(YIQIROOT.'/comment.html', $commentsource, true);
		$htmlmsg = "生成HTML完成.";
		break;
}
if ($htmlmsg == "生成HTML完成.")
	$htmlmsg .= "<a href='javascript:window.history.go(-1);'>返回上页</a>";
else
	$htmlmsg .= "<br /><a href='$nextlink'>如果长时间无响应请点这里继续...</a>";
	
function getcategorysource($category, $curpage) {
	global $articledata, $productdata,$categorydata,$tempinfo;
	
	if($category->type == "article") {
		$articlecount = $articledata->GetArticleList($category->cid);
		$total = count($articlecount);
		$take = $category->takenumber;
		$skip = ($curpage - 1) * $take;
		$totalpage = (int)($total % $take == 0 ? $total / $take : $total / $take + 1);
		$articlelist = $articledata->TakeArticleList($category->cid,$skip,$take);
		$tempinfo->assign("articlelist",$articlelist);
	}
	else if($category->type == "product") {
		$productcount = $productdata->GetProductList($category->cid);
		$total = count($productcount);
		$take = $category->takenumber;
		$skip = ($curpage - 1) * $take;
		$totalpage = (int)($total % $take == 0 ? $total / $take : $total / $take + 1);
		$productlist = $productdata->TakeProductList($category->cid,$skip,$take);
		$tempinfo->assign("productlist",$productlist);
	}
	if($curpage > 1) {		
		$category->seotitle = preg_replace("/第([\d]+)页/i","",$category->seotitle). ' 第'.$curpage.'页';
	}
	$tempinfo->assign("category",$category);
	$tempinfo->assign("subcategory",$categorydata->GetSubCategory($category->cid,$category->type));

	$tempinfo->assign("take",$take);
	$tempinfo->assign("total",$total);
	$tempinfo->assign("totalpage",$totalpage);
	$tempinfo->assign("curpage",$curpage);
	$source = $tempinfo->fetch($category->templets);
	
	return array('source'=>$source,'totalpage'=>$totalpage,'curpage'=>$curpage);
}
function redirect($url) {
	echo "<script>
	setInterval('redir()',500);
	function redir() {
		window.location.href='$url';
	}
	</script>";
}
?>
<?php
$adminpagetitle = "URL设置";
include("admin.header.php");?>
<div class="main_body">
<?php if ($gt == "" ) {　?>
<form id="sform" action="option-html.php" method="post">
<table class="inputform" cellpadding="1" cellspacing="1">
<tr><td class="label">生成HTML选项</td><td class="input">
	<select name="genoption">
		<option value="all">全部生成</option>
		<option value="home">首页</option>
		<option value="article">文章</option>
		<option value="product">产品</option>
		<option value="category">分类(包括文章分类和产品分类)</option>
		<option value="maps">文章地图、留言页</option>
	</select></td></tr>
</table>
<div class="clear">&nbsp;</div>
<div class="inputsubmit"><input type="hidden" name="action" value="save" /><input id="submitbtn" type="submit" class="subtn" value="提交" /></div>
</form>
<?php } else { echo $htmlmsg; }?>
</div>
</div>

<div class="clear">&nbsp;</div>
<?php include("admin.footer.php");?>
</div>
<script type="text/javascript">
$(function(){
    $("input[name='html']").each(function(){
    	if($(this).val() == "<?php echo getset("urlrewrite")->value;?>")
    	{
    		$(this).attr("checked","checked");
    	}
    });
});
</script>
</body>

</html>