<dl> 
<dt><a href="../" target="_blank">网站首页</a>&nbsp;<a href="index.php">后台首页</a>&nbsp;<a href="cleancache.php">清除缓存</a></dt>

<?php

require_once 'admin.inc.php';

$regularlist = GetRegular();

if(count($regularlist) > 0)
{
    foreach($regularlist as $regularinfo)
    {
        $subregularlist = GetRegular($regularinfo->rid);
        if(count($subregularlist) > 0)
        {
            echo "<dt class=\"submenuheader\" style=\"cursor:pointer;\"><img src=\"../images/plus.gif\" alt=\"查看子分类\" title=\"查看子分类\"/>&nbsp;&nbsp;<a href=\"$regularinfo->value\">$regularinfo->name</a></dt>";
            echo "<dd><div class=\"submenu\"><ul>";
            foreach($subregularlist as $subregular)
            {
                if($subregular->status == 'ok')
                {
                    if(checkregular($subregular->rid))
                    {
                        echo "<li><a href=\"$subregular->value\">$subregular->name</a></li>";
                    }
                }
            }
            echo "</ul></div></dd>";
        }
        else
        {
            echo "<dt><img src=\"../images/plus.gif\" />&nbsp;&nbsp;<a href=\"$regularinfo->value\">$regularinfo->name</a></dt>";
        }
    }
}

function GetRegular($pid=0)
{
    global $yiqi_db;
    $sql = "SELECT * FROM yiqi_regular WHERE pid = '$pid' order by displayorder";
    return $yiqi_db->get_results(CheckSql($sql));
}
?>
</dl>
<script type="text/javascript" src="../images/ddaccordion.js"></script>
<script type="text/javascript">
ddaccordion.init({
	headerclass: "submenuheader",contentclass: "submenu",
	revealtype: "click",
	mouseoverdelay: 200,
	collapseprev: true, 
	defaultexpanded: [],
	onemustopen: false, 
	animatedefault: false,
	persiststate: true, 
	toggleclass: ["", ""],
	togglehtml: ["suffix", "", ""], 
	animatespeed: "fast", 
	oninit:function(headers, expandedindices){ 
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ 
		//do nothing
	}
});
</script>

