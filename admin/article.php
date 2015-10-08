<?php
require_once 'admin.inc.php';
require_once '../include/article.class.php';
require_once '../include/category.class.php';
$cid=$_GET["cid"];
$curpage=$_GET["p"];
$cid = (isset($cid) && is_numeric($cid)) ? $cid : 0;
$curpage = (isset($curpage) && is_numeric($curpage)) ? $curpage : 1;
if($curpage<1)
{
	$curpage=1;
}
$articledata = new Article;
$articlecount = $articledata->GetArticleList($cid,"aid desc",true);
$total = count($articlecount);
$take = 20;
$skip = ($curpage - 1) * $take;
$totalpage = (int)($total % $take == 0 ? $total / $take : $total / $take + 1);
$articlelist = $articledata->TakeArticleList($cid,$skip,$take,"aid desc",true);
$action = $_POST["action"];
if($action == "delete")
{
    $idarr = $_POST["chk"];
	if(count($idarr) > 0)
	{
		foreach($idarr as $id)
		{
			if(is_numeric($id))
			{
				$sql = "DELETE FROM yiqi_article WHERE aid = '$id' limit 1";
				$yiqi_db->query(CheckSql($sql));
			}
		}
		ShowMsg("指定文章删除成功");
	}
}
?>
<?php
$adminpagetitle = "文章列表";
include("admin.header.php");?>
<div class="main_body">
<form action="article.php" method="post">
<table class="inputform" cellpadding="1" cellspacing="1">
<tr style="background:#f6f6f6;"><td class="w10">选择</td><td class="w50">文章标题</td><td class="20">所属分类</td><td class="w10">发布状态</td><td class="w10">相关操作</td></tr>
<?php
if(count($articlelist)>0)
{
    foreach($articlelist as $article)
    {
        $categoryname = "未分类";
        $categorydata = new Category;
        $categoryinfo = $categorydata->GetCategory($article->cid);
        if($categoryinfo!=null)
        {
            $categoryname = $categoryinfo->name;
        }
		$pubstatus = '<span title="该文章已发布">已发布</span>';
		if(phpversion() > '5.1.0')
			date_default_timezone_set('Asia/Shanghai');
		if(strtotime($article->adddate) > strtotime(gmstrftime(date("c"))))
		{
			$pubstatus = "<span title=\"该文章将于：".$article->adddate."发布\">定时发布</span>";
		}
        echo "<tr>".
            "<td><input id=\"slt$article->aid\" type=\"checkbox\" name=\"chk[]\" value=\"$article->aid\" /></td>".
			"<td><a href=\"../article.php?name=".urlencode($article->filename)."\" target=\"_blank\">$article->title</a></td>".
            "<td><a href=\"article.php?cid=".$categoryinfo->cid."\">$categoryname</a></td>".
			"<td>$pubstatus</td>".
            "<td><a href=\"article-edit.php?aid=$article->aid\">修改</a></td>".
            "</tr>";
    } 
}
?>
</table>
<div class="clear">&nbsp;</div>
<div class="fl" style="text-indent:16px;"><input id="slt" type="checkbox"/>&nbsp;&nbsp;<select name="action"><option value="-">批量应用</option><option value="delete">删除</option></select>&nbsp;<input type="submit" class="subtn" value="提交" onclick="if(!confirm('确认执行相应操作?')) return false;"/></div>
<div class="fr">
<?php 
$_SERVER["QUERY_STRING"] = preg_replace("/(&)?p=[0-9]{1,3}(&)?/","",$_SERVER["QUERY_STRING"]);
echo "共${total}条文章 当前${curpage}/${totalpage}页 ";
if($curpage > 1)
{
    if($cid==0)
    {
        echo "<a href=\"article.php?p=1\">首页</a>".
        	 "&nbsp;<a href=\"article.php?p=".($curpage-1)."\">上一页</a>";
    }
    else
    {
        echo "<a href=\"article.php??cid=$cid&p=1\">首页</a>".
        	 "&nbsp;<a href=\"article.php??cid=$cid&p=".($curpage-1)."\">上一页</a>";
    }
}
if($curpage > 0 && $curpage < $totalpage)
{
    if($cid==0)
    {
        echo "&nbsp;<a href=\"article.php?p=".($curpage+1)."\">下一页</a>".
        	 "&nbsp;<a href=\"article.php?p=$totalpage\">尾页</a>";
    }
    else
    {
        echo "&nbsp;<a href=\"article.php?cid=$cid&p=".($curpage+1)."\">下一页</a>".
        	 "&nbsp;<a href=\"article.php?cid=$cid&p=$totalpage\">尾页</a>";
    }
}
?>
</div>
</form>
<div class="clear">&nbsp;</div>
<div style="color:#ff0000;font-size:14px;"><strong>提示："定时发布"的文章，只有管理员可以看到，未到发布时间不能在前台显示，正式发布后，会自动显示。<br />　　　“已发布”的文章，任何人都可正常访问。<br/></strong></div>
</div>

</div>

<div class="clear">&nbsp;</div>
<?php include("admin.footer.php");?>
</div>

</body>

</html>