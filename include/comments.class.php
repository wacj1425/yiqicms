<?php
require_once("data.class.php");

class Comments
{
    function GetComment($cid)
	{
	    global $yiqi_db;
	    if($this->ExistComment($cid)==1)
	    {
	        $sql = "select * from yiqi_comments where cid = '$cid' limit 1";
	        return $yiqi_db->get_row(CheckSql($sql));
	    }
	    else
	    {
	        return null;
	    }
	}
	
    function ExistComment($cid)
	{
	    global $yiqi_db;
	    $sql = "select * from yiqi_comments where cid = '$cid' limit 1";	    
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
	
    function GetCommentsList($orderby="adddate desc")
	{
	    global $yiqi_db;
		return $yiqi_db->get_results(CheckSql("select * from yiqi_comments order by $orderby"));
	}
	
	function TakeCommentsList($skip=0,$take=10,$orderby="adddate desc")
	{
	    global $yiqi_db;
		return $yiqi_db->get_results(CheckSql("select * from yiqi_comments order by $orderby limit $skip,$take"));		
	}
}
?>