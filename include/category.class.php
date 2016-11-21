<?php

require_once("data.class.php");

class Category
{
    function GetCategory($cid=0)
	{
	    global $yiqi_db;
	    if($this->ExistCategory($cid) ==1 )
	    {
	        $sql = "select * from yiqi_category where cid = '$cid' limit 1";
	        return $yiqi_db->get_row(CheckSql($sql));
	    }
	    else
	    {
	        return null;
	    }
	}
	
    function GetCategoryByName($name)
	{
	    global $yiqi_db;
	    if($this->ExistFilename($name) == 1 )
	    {
	        $sql = "select * from yiqi_category where filename = '$name' limit 1";
	        return $yiqi_db->get_row(CheckSql($sql));
	    }
	    else
	    {
	        return null;
	    }
	}
	
	function GetCategoryParentIDs($cid)
	{
		global $yiqi_db;
		$cids = array();
		$catinfo = $this->GetCategory($cid);
		if($catinfo != null)
		{
			$pid = $catinfo->pid;
			if($pid != 0)
			{
				$cids[] = $pid;
				$cids = array_merge($cids,$this->GetCategoryParentIDs($pid));
			}
		}
		else
		{
			$cids = null;
		}
		return $cids;
	}
	
	function GetSubCategoryIDs($cid=0,$all=true)
    {
    	global $yiqi_db;
		$cids = array();
		$catinfo = $this->GetCategory($cid);
		if($catinfo != null)
		{
			$sql = "select * from yiqi_category where pid = '$cid'";
			$results = $yiqi_db->get_results(CheckSql($sql));
			if(count($results) > 0)
			{
				foreach($results as $result)
				{
					$cids[] = $result->cid;
					$cids = array_merge($cids,$this->GetSubCategoryIDs($result->cid));
				}
			}
		}
		else
		{
			$cids = null;
		}
		return $cids;
    }
    
    function ExistCategory($cid=0)
    {
        global $yiqi_db;
	    $sql = "select * from yiqi_category where cid = '$cid' limit 1";	    
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
    
    function ExistFilename($filename)
	{
	    global $yiqi_db;
	    $sql = "select * from yiqi_category where filename = '$filename' limit 1";
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
    
    function GetSubCategory($pid=0,$type='article',$orderby="displayorder")
    {
    	global $yiqi_db;
    	$sql = "select * from yiqi_category where pid = '$pid' and type = '$type' order by $orderby";
		$results = $yiqi_db->get_results(CheckSql($sql));
		if(count($results))
		{
		    return $results;
		}
		else
		{
		    return null;
		}
    }
    
	function GetCategoryList($pid=0,$type='article',$depth=0,$prefixchar='　')
	{
		$resultarray = array();
		$results = $this->GetSubCategory($pid,$type);
		if(count($results) > 0)
		{
			if($pid==0)
			{
				$depth = 0;
			}
			else
			{
				$depth++;
			}
			$prefix = str_repeat($prefixchar,$depth);
			for($i=0;$i<count($results);$i++)
			{
				$resultarray[] = $results[$i];
				$results[$i]->name = $prefix.$results[$i]->name;				
				
				$resultarray = array_merge($resultarray,$this->GetCategoryList($results[$i]->cid,$type,$depth,$prefixchar));
			}
			
		}
		return $resultarray;
	}
}
?>