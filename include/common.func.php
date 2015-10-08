<?php
require_once 'keywords.class.php';
function ShowMsg($msg,$redirect='')
{
    if($redirect == 'back')
    {
        echo "<script>alert('$msg');window.history.go(-1);</script>";
    }
    else
    {
        $redirect = $_SERVER["REQUEST_URI"];
        echo "<script>alert('$msg');window.location.href='$redirect';</script>";
    }
}

function safeCheck($str) 
{ 
    $farr = array(
        "/<(\/?)(script|i?frame|style|html|body|title|link|object|meta|\?|\%)([^>]*?)>/isU",  //过滤 <script 等可能引入恶意内容或恶意改变显示布局的代码,如果不需要插入flash等,还可以加入<object的过滤 
        "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU",                                      //过滤javascript的on事件 
      
   ); 
   $tarr = array(
        "", 
        "", 
   ); 

  $str = preg_replace($farr,$tarr,$str); 
   return $str; 
}

function array_remove_value ()
{
  $args = func_get_args();
  return array_diff($args[0],array_slice($args,1));
}
	
function mixkeyword($contentsource) {
	$keywordsdata = new Keywords();
	$keywordslist = $keywordsdata->GetKeywordsList();

	$replacedarray = array();
	$matchnum = 0;
	if(count($keywordslist) > 0)
	{
		foreach($keywordslist as $keywords)
		{	
			if(preg_match_all("/(<a[^>]+>.*?<\/a>)|(<img[^>]+>)|<strong>.*?<\/strong>|<h[1-6]>.*?<\/h[1-6]>/i",$contentsource,$matches,PREG_SET_ORDER))
			{	
				foreach($matches as $match)
				{
					$contentsource = str_replace($match[0],"<link>".$matchnum."</link>",$contentsource);
					$replacedarray[$matchnum] = $match[0];
					$matchnum++;
				}
			}
			if($keywords->url != $cururl)
			{
				$patterns = "/(?<!<link>)$keywords->name(?!<\/link>)/i";	
				$replacements = '<a href="'.$keywords->url.'">'.$keywords->name.'</a>';
				$contentsource = preg_replace($patterns,$replacements,$contentsource,1);
			}
			else
			{
				$patterns = "/(?<!<link>)$keywords->name(?!<\/link>)/i";
				$replacements = '<strong>'.$keywords->name.'</strong>';
				$contentsource = preg_replace($patterns,$replacements,$contentsource,1);
			}
		}
	}
	if(preg_match_all("/(?<=<link>)\d+(?=<\/link>)/",$contentsource,$matches,PREG_SET_ORDER))
	{	
		foreach($matches as $match)
		{
			$contentsource = str_replace("<link>".$match[0]."</link>",$replacedarray[$match[0]],$contentsource);
		}
	}
	return $contentsource;
}
?>