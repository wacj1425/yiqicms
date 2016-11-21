<?php
require_once("data.class.php");

Class Keywords
{
	function GetKeyword($kid)
	{
		global $yiqi_db;
	    if($this->ExistKeyword($kid)==1)
	    {
	        $sql = "select * from yiqi_keywords where kid = '$kid' limit 1";
	        return $yiqi_db->get_row(CheckSql($sql));
	    }
	    else
	    {
	        return null;
	    }
	}
	
	function GetKeywordByName($name)
	{
		global $yiqi_db;
	    if($this->ExistKeywordByName($name)==1)
	    {
	        $sql = "select * from yiqi_keywords where name = '$name' limit 1";
	        return $yiqi_db->get_row(CheckSql($sql));
	    }
	    else
	    {
	        return null;
	    }
	}
	
	function ExistKeyword($kid)
	{
	    global $yiqi_db;
	    $sql = "select * from yiqi_keywords where kid = '$kid' limit 1";	    
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
	
	function ExistKeywordByName($name)
	{
	    global $yiqi_db;
	    $sql = "select * from yiqi_keywords where name = '$name' limit 1";	    
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
	
	function GetKeywordsList($where="")
	{
	    global $yiqi_db;
	    if($where=="")
	    {
			return $yiqi_db->get_results(CheckSql("select * from yiqi_keywords order by displayorder"));
	    }
	    else
	    {
	    	return $yiqi_db->get_results(CheckSql("select * from yiqi_keywords $where order by displayorder"));
	    }	
	}
	
	function TakeKeywordsList($skip=0,$take=10,$where = "",$orderby="displayorder")
	{
	    global $yiqi_db;
	    if($where == "")
	    {
			return $yiqi_db->get_results(CheckSql("select * from yiqi_keywords order by $orderby limit $skip,$take"));
	    }
	    else
	    {
	    	return $yiqi_db->get_results(CheckSql("select * from yiqi_keywords $where order by $orderby limit $skip,$take"));
	    }	
	}
}


?>