<?php
require_once 'data.class.php';

class Meta
{
    function GetMeta($id)
    {
        global $yiqi_db;
	    if($this->ExistMeta($id)==1)
	    {
	        $sql = "select * from yiqi_meta where metaid = '$id' limit 1";
	        return $yiqi_db->get_row(CheckSql($sql));
	    }
	    else
	    {
	        return null;
	    }
    }
	
	function GetMetaName($type,$name,$id)
	{
	    global $yiqi_db;
		if($this->ExistMetaName($type,$name,$id)==1)
	    {
	        $sql = "select * from yiqi_meta where metatype = '$type' and metaname = '$name' and objectid = '$id' limit 1";			
	        return $yiqi_db->get_row(CheckSql($sql));
	    }
	    else
	    {
	        return null;
	    }
	}
    
    function ExistMeta($id)
	{
	    global $yiqi_db;
	    $sql = "select * from yiqi_meta where metaid = '$id' limit 1";	    
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
	
	function ExistMetaName($type,$name,$id)
	{
	    global $yiqi_db;
	    $sql = "select * from yiqi_meta where metatype = '$type' and metaname = '$name' and objectid = '$id' limit 1";	    
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
	
	function GetMetaList($type,$postid,$orderby="metaid")
	{
	    global $yiqi_db;
		return $yiqi_db->get_results(CheckSql("select * from yiqi_meta where metatype = '$type' and objectid = '$postid' order by $orderby"));
	}
	
	function TakeMetaList($skip=0,$take=10,$orderby="metaid")
	{
	    global $yiqi_db;
		if($take<1)
		{
			return $yiqi_db->get_results(CheckSql("select metaid from yiqi_meta"));	
		}
		else
		{
			return $yiqi_db->get_results(CheckSql("select * from yiqi_meta order by $orderby limit $skip,$take"));	
		}
	}
}
?>