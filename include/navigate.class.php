<?php
require_once 'data.class.php';

class Navigate
{
    function GetNavigate($id)
    {
        global $yiqi_db;
	    if($this->ExistNavigate($id)==1)
	    {
	        $sql = "select * from yiqi_navigate where navid = '$id' limit 1";
	        return $yiqi_db->get_row(CheckSql($sql));
	    }
	    else
	    {
	        return null;
	    }
    }
    
    function ExistNavigate($id)
	{
	    global $yiqi_db;
	    $sql = "select * from yiqi_navigate where navid = '$id' limit 1";	    
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
	
    function GetNavigateList($group=false,$orderby="convert(`group` USING gbk) COLLATE gbk_chinese_ci,displayorder,navid")
	{
	    global $yiqi_db;
		if($group)
		{
			return $yiqi_db->get_results(CheckSql("select * from yiqi_navigate as nav where nav.group = '$group' and nav.status = 'ok' order by $orderby"));
		}
		else
		{
			return $yiqi_db->get_results(CheckSql("select * from yiqi_navigate as nav where nav.status = 'ok' order by $orderby"));
		}
	}
	
	function TakeNavigateList($group=false,$skip=0,$take=10,$orderby="convert(`group` USING gbk) COLLATE gbk_chinese_ci,displayorder,navid")
	{
	    global $yiqi_db;
		if($group)
		{
			return $yiqi_db->get_results(CheckSql("select * from yiqi_navigate as nav where nav.group = '$group' AND nav.status = 'ok' order by $orderby limit $skip,$take"));		
		}
		else
		{
			return $yiqi_db->get_results(CheckSql("select * from yiqi_navigate as nav where nav.status = 'ok' order by $orderby limit $skip,$take"));	
		}
	}
}
?>