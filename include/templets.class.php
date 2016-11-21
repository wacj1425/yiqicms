<?php

require_once 'Smarty/libs/Smarty.class.php';

class Templets extends Smarty
{
    function GetTemplets($tid)
    {
        global $yiqi_db;
        $tempinfo = $yiqi_db->get_row(CheckSql("select * from yiqi_templets where tid = '$tid' limit 1"));
        if(is_object($tempinfo))
        {
            return $tempinfo;
        }
        else
        {
            return null;
        }
    }
    
    function GetDefaultTemplets()
    {
        global $yiqi_db;
        $defaulttemplets = $yiqi_db->get_row(CheckSql("select * from yiqi_settings where varname = 'sitetemplets' limit 1"));
         if(is_object($defaulttemplets))
        {
            return $this->GetTemplets($defaulttemplets->value);
        }
        else
        {
            return null;
        }
    }
}
?>