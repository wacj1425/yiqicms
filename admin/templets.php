<?php
require_once 'admin.inc.php';

$dirlist = explode(',',get_dirs(YIQIROOT.'/templets/')) ;
foreach($dirlist as $dirinfo)
{
	if($dirinfo != '')
	{
		$doc = new DOMDocument();
		$configfile = YIQIROOT.'/templets/'.$dirinfo.'/config.xml';
		if(file_exists($configfile))
		{
			$doc->load($configfile);
			$config = $doc->getElementsByTagName("yiqitemplet");			
			$tempname =  $config->item(0)->getElementsByTagName('name')->item(0)->nodeValue;
			$tempauthor =  $config->item(0)->getElementsByTagName('author')->item(0)->nodeValue;
			$tempcopyright =  $config->item(0)->getElementsByTagName('copyright')->item(0)->nodeValue;
			$temppubdate =  $config->item(0)->getElementsByTagName('pubdate')->item(0)->nodeValue;	
			
			if($tempname != '' && $tempauthor != '')
			{
				//判断模板是否存在
				$sql = "select * from yiqi_templets where name = '$tempname' and directory = '$dirinfo' limit 1";
				if($yiqi_db->query(CheckSql($sql)) == 0)
				{
					//将不存在的模板添加到数据库
					$sql = "insert into yiqi_templets(name,directory,thumb,author,copyright,adddate,status) values". 
						   "('$tempname','$dirinfo','../templets/$dirinfo/preview.gif','$tempauthor','$tempcopyright','$temppubdate','ok')";
					$yiqi_db->query(CheckSql($sql));
				}
			}
		}
	}
}

$tid = getset("sitetemplets")->value;
$sql = "select * from yiqi_templets where status = 'ok' order by tid";
$templetslist = $yiqi_db->get_results(CheckSql($sql));

$count = count($templetslist);

$action = $_POST['action'];
if($action == "update")
{
    $tempid=$_POST["tid"];
	$tempid = (isset($tempid) && is_numeric($tempid)) ? $tempid : 0;
	if($tempid==0||!is_numeric($tempid))
	{
		exit();
	}
	require_once ('../include/templets.class.php');
	$tempinfo = new Templets();
	$tempinfo->compile_dir = YIQIROOT.'/cache/compile/';
	$tempinfo->clear_compiled_tpl();
	upset("sitetemplets",$tempid);
	ShowMsg("网站模板设置成功");
}
else if($action == "delete")
{
    $tempid=$_POST["tid"];
	$tempid = (isset($tempid) && is_numeric($tempid)) ? $tempid : 0;
	if($tempid==0||!is_numeric($tempid))
	{
		exit();
	}
	$sql = "delete from yiqi_templets where tid = '$tid' limit 1";
	if($yiqi_db->query(CheckSql($sql))==1)
	{
	    ShowMsg("指定模板删除成功");
	}
}

function get_dirs($dir){ 
    $dirs = ''; 
    if(is_dir($dir)){
	    if ($handle = opendir($dir)){ 
	        while (false !== ($file = readdir($handle))){ 
	            if (filetype($dir.$file) === 'dir' && $file != "." && $file != ".."){ 
	                clearstatcache(); 
	                $dirs .= $file . ","; 
	            } 
	        } 
	        closedir($handle); 
	    }
    } 
    return $dirs; 
}

?>
<?php
$adminpagetitle = "模板设置";
include("admin.header.php");?>
<div class="main_body">
<strong style="color:#ff0000;">提示：如果要删除模板，请使用ftp。模板在templets文件夹下面。</strong>
<table class="inputform" cellpadding="1" cellspacing="1" style="text-indent:0px;text-align:center;">
<tr style="background:#f6f6f6;"><td class="w30">缩略图</td><td class="50">作者/版权信息</td><td class="w20">相关操作</td></tr>
<?php 
if(count($templetslist)>0)
{
    foreach($templetslist as $tempinfo)
    {
    	if(file_exists(YIQIROOT.'/templets/'.$tempinfo->directory))
    	{
	        if($tempinfo->tid == $tid)
	        {
	            echo "<tr style=\"height:150px;background:#efefef;\">";
	        }
	        else
	        {
	            echo "<tr style=\"height:150px;\">";
	        }        
	        echo "<td><img src=\"$tempinfo->thumb\" style=\"width:180px;height: 120px;\"/></td>".
	        	 "<td style=\"text-align: left\">$tempinfo->name<br/>".
	        	 "$tempinfo->author<br/>".
	        	 "$tempinfo->copyright<br/><br/><br/></td>".
	        	 "<td><a href=\"javascript:void(0);\" onclick=\"settemp('$tempinfo->tid')\">启用</a></td>".
	        	 "</tr>";
    	}
    	else
    	{
	    	$sql = "delete from yiqi_templets where tid = '$tempinfo->tid' limit 1";
			$yiqi_db->query(CheckSql($sql));
    	}
    }
}
?>
</table>
<form id="tempform" action="" method="post">
<input type="hidden" id="action" name="action" value="update"/>
<input type="hidden" id="tid" name="tid" value="0"/>
</form>
</div>

</div>

<div class="clear">&nbsp;</div>
<?php include("admin.footer.php");?>
</div>
<script type="text/javascript">
function settemp(tempid)
{
	if(confirm("确认使用选中的模板"))
	{
    	$("#tid").val(tempid);
		setTimeout(form_submit,1);
	}
}
function form_submit()
{
	$("#tempform").trigger("submit");
}
</script>
</body>

</html>