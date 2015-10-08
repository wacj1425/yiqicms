<?php

require_once("data.class.php");

class User
{
    function GetUser($uid=0)
    {
        global $yiqi_db;
	    if($this->ExistUser($uid)==1)
	    {
	        $sql = "select * from yiqi_users where uid = '$uid' limit 1";
	        return $yiqi_db->get_row(CheckSql($sql));
	    }
	    else
	    {
	        return null;
	    }
    }
    
    function GetUserByName($username)
    {
        global $yiqi_db;
        $sql = "select * from yiqi_users where username = '$username' limit 1";
        return $yiqi_db->get_row(CheckSql($sql));
    }
    
    function ExistUser($uid)
	{
	    global $yiqi_db;
	    $sql = "select * from yiqi_users where uid = '$uid' limit 1";	    
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
	
	function ExistUserPassword($username,$password)
	{
	    global $yiqi_db;
	    $password = md5($password);
	    $sql = "select * from yiqi_users where username = '$username' and password = '$password' limit 1";	    
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
	
    function GetUserList()
	{
	    global $yiqi_db;
		return $yiqi_db->get_results(CheckSql("select * from yiqi_users order by adddate desc,uid desc"));
	}
	
	function TakeUserList($skip=0,$take=10)
	{
	    global $yiqi_db;
		return $yiqi_db->get_results(CheckSql("select * from yiqi_users order by adddate desc,uid desc limit $skip,$take"));		
	}
}
?>