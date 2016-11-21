<?php

require_once("data.class.php");
require_once("category.class.php");

class Article
{    
	function GetArticle($aid,$all=false)
	{
	    global $yiqi_db;
	    if($this->ExistArticle($aid,$all)==1)
	    {
			if($all)
			{
				return $yiqi_db->get_row(CheckSql("select * from yiqi_article where aid = '$aid' limit 1"));
			}
	        else
			{
				return $yiqi_db->get_row(CheckSql(sprintf("select * from yiqi_article where aid = '$aid' and adddate <= '%s' limit 1",date("Y-m-d H:i:s"))));
			}
	    }
	    else
	    {
	        return null;
	    }
	}
	
	function GetNextArticle($article)
	{
	    global $yiqi_db;
	    if($this->ExistArticle($article->aid)==1)
	    {
	        $sql = sprintf("select * from yiqi_article where aid > '$article->aid' and adddate <= '%s' limit 1",date("Y-m-d H:i:s"));
	        return $yiqi_db->get_row(CheckSql($sql));
	    }
	    else
	    {
	        return null;
	    }
	}
	
    function GetPrevArticle($article)
	{
	    global $yiqi_db;
	    if($this->ExistArticle($article->aid)==1)
	    {
	        $sql = sprintf("select * from yiqi_article where aid < '$article->aid' and adddate <= '%s' order by adddate desc limit 1",date("Y-m-d H:i:s"));
	        return $yiqi_db->get_row(CheckSql($sql));
	    }
	    else
	    {
	        return null;
	    }
	}
	
	function GetArticleByName($name,$all=false)
	{
	    global $yiqi_db;
	    if($this->ExistFilename($name,$all))
	    {
			$sql = '';
			if($all)
			{
				$sql = "select * from yiqi_article where filename = '$name' limit 1";
			}
			else
			{
				$sql = sprintf("select * from yiqi_article where filename = '$name' and adddate <= '%s' limit 1",date("Y-m-d H:i:s"));
			}
	        return $yiqi_db->get_row(CheckSql($sql));
	    }
	    else
	    {
	        return null;
	    }
	}
	
	function ExistArticle($aid,$all=false)
	{
	    global $yiqi_db;
		$sql = '';
		if($all)
		{
			$sql = "select * from yiqi_article where aid = '$aid' limit 1";
		}
		else
		{
			$sql = sprintf("select * from yiqi_article where aid = '$aid' and adddate <= '%s' limit 1",date("Y-m-d H:i:s"));
		}
	    $exist = $yiqi_db->query(CheckSql($sql));
	    if($exist == 0)
	    {
	        return 0;
	    }
	    else
	    {
	        return 1;
	    }	    
	}
	
	function ExistFilename($filename,$all=false)
	{
	    global $yiqi_db;
		$sql = '';
		if($all)
		{
			$sql = "select * from yiqi_article where filename = '$filename' limit 1";
		}
		else
		{
			$sql = sprintf("select * from yiqi_article where filename = '$filename' and adddate <= '%s' limit 1",date("Y-m-d H:i:s"));
		}
	    $exist = $yiqi_db->query(CheckSql($sql));
	    if($exist == 0)
	    {
	        return 0;
	    }
	    else
	    {
	        return 1;
	    }
	}
	
	function GetArticleList($cid,$orderby="adddate desc",$all=false)
	{
	    global $yiqi_db;
	    $categorydata = new Category();	    
    	$exist = $categorydata->ExistCategory($cid);
		if($exist == 1)
		{
			$cids = array($cid);
			$cids = array_merge($cids,$categorydata->GetSubCategoryIDs($cid));			
			$cids = implode(',', $cids);
			if($all)
			{
				return $yiqi_db->get_results(CheckSql("select * from yiqi_article where cid in ($cids) order by $orderby "));
			}
			else
			{
				return $yiqi_db->get_results(CheckSql(sprintf("select * from yiqi_article where cid in ($cids) and adddate <= '%s' order by $orderby ",date("Y-m-d H:i:s"))));
			}
		}
		else
		{
			if($all)
			{
				return $yiqi_db->get_results(CheckSql("select * from yiqi_article order by $orderby"));
			}
			else
			{
				return $yiqi_db->get_results(CheckSql(sprintf("select * from yiqi_article where adddate <= '%s' order by $orderby",date("Y-m-d H:i:s"))));
			}
		}
	}	
	
	function TakeArticleList($cid=0,$skip=0,$take=10,$orderby="adddate desc",$all=false)
	{
	    global $yiqi_db;
	    $categorydata = new Category();	    
    	$exist = $categorydata->ExistCategory($cid);
		if($exist == 1)
		{
			$cids = array($cid);
			$cids = array_merge($cids,$categorydata->GetSubCategoryIDs($cid));			
			$cids = implode(',', $cids);
			if($all)
			{
				return $yiqi_db->get_results(CheckSql("select * from yiqi_article where cid in ($cids) order by $orderby limit $skip,$take "));
			}
			else
			{
				return $yiqi_db->get_results(CheckSql(sprintf("select * from yiqi_article where cid in ($cids) and adddate <= '%s' order by $orderby limit $skip,$take ",date("Y-m-d H:i:s"))));
			}
		}
		else
		{
			if($all)
			{
				return $yiqi_db->get_results(CheckSql("select * from yiqi_article order by $orderby limit $skip,$take"));
			}
			else
			{
				return $yiqi_db->get_results(CheckSql(sprintf("select * from yiqi_article where adddate <= '%s' order by $orderby limit $skip,$take",date("Y-m-d H:i:s"))));
			}
		}
	}
	
    function TakeArticleListByName($name="",$skip=0,$take=10,$orderby="adddate desc",$all=false)
	{
	    global $yiqi_db;
	    $categorydata = new Category();	    
    	$exist = $categorydata->ExistFilename($name);
		if($exist == 1)
		{
		    $category = $categorydata->GetCategoryByName($name);
			$cids = array($category->cid);
			$cids = array_merge($cids,$categorydata->GetSubCategoryIDs($category->cid));			
			$cids = implode(',', $cids);
			if($all)
			{
				return $yiqi_db->get_results(CheckSql("select * from yiqi_article where cid in ($cids) order by $orderby limit $skip,$take "));
			}
			else
			{
				return $yiqi_db->get_results(CheckSql(sprintf("select * from yiqi_article where cid in ($cids) and adddate <= '%s' order by $orderby limit $skip,$take ",date("Y-m-d H:i:s"))));
			}
		}
		else
		{
			if($all)
			{
				return $yiqi_db->get_results(CheckSql("select * from yiqi_article order by $orderby limit $skip,$take"));
			}
			else
			{
				return $yiqi_db->get_results(CheckSql(sprintf("select * from yiqi_article where adddate <= '%s' order by $orderby limit $skip,$take",date("Y-m-d H:i:s"))));
			}
		}
	}
	
	function UpdateCount($aid)
	{
	    global $yiqi_db;
	    $sql = "UPDATE yiqi_article SET viewcount = viewcount+1 where aid = '$aid' limit 1";
	    $yiqi_db->query(CheckSql($sql));
	}
}

?>