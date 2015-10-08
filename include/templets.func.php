<?php

function formaturl($params)
{
    global $yiqi_db;
    extract($params);
    $sql = "select * from yiqi_settings where varname = 'urlrewrite' limit 1";
    $result = $yiqi_db->get_row(CheckSql($sql));
	if(strpos($name,"http://")===0)
		return $name;
	$name = urlencode($name);
    if($result->value == "true" || $result->value == "html" || $generatehtml )
    {
        switch($type)
        {
            case "category":
                if(is_numeric($page) && $page > 1)
                    $urlinfo = "category/$name"."_"."$page/";                    
                else
                    $urlinfo = "category/$name/";
                break;
            case "article":
                $urlinfo = "article/$name.html";
                break;
            case "product":
                $urlinfo = "product/$name.html";
                break;
            case "catalog":
                $urlinfo = "catalog/$name/";
                break;
            case "comment":
                $urlinfo = "comment.html";
                break;
			case "sitemap":
				$urlinfo = "sitemap.xml";
				break;
        }
    }
    else
    {
        switch($type)
        {
            case "category":
                if(is_numeric($page))
                    $urlinfo = "category.php?name=$name&p=$page";                    
                else
                    $urlinfo = "category.php?name=$name";
                break;
            case "article":
                $urlinfo = "article.php?name=$name";
                break;
            case "product":
                $urlinfo = "product.php?name=$name";
                break;
            case "catalog":
                $urlinfo = "catalog.php?type=$name";
                break;
            case "comment":
                $urlinfo = "comment.php";
                break;
			case "sitemap":
                $urlinfo = "sitemap.php";
                break;
        }
    }
	$rurl = $siteurl."/".$urlinfo;
	if ($generatehtml) 
		$rurl = $urlinfo;
    return $rurl;
}

function readrss($params)
{
	extract($params);
	$buff = ""; 
	$rss_str=""; 
	$fp = fopen($url,"r") or die("can not open $rssfeed"); 
	while ( !feof($fp) ) { 
		$buff .= fgets($fp,4096); 
	}
	fclose($fp);
	$parser = xml_parser_create();
	xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1);
	xml_parse_into_struct($parser,$buff,$values,$idx);
	xml_parser_free($parser); 
	foreach ($values as $val) {
		$tag = $val["tag"]; 
		$type = $val["type"]; 
		$value = $val["value"];
		$tag = strtolower($tag); 
		if ($tag == "item" && $type == "open"){ 
			$is_item = 1; 
		}else if ($tag == "item" && $type == "close") {
			$rss_str .= "<li><a href='".$link."' target=_blank>".$title."</a></li>"; 
			$is_item = 0; 
		}
		if($is_item==1){ 
			if ($tag == "title") {$title = $value;} 
			if ($tag == "link") {$link = $value;} 
		} 
	}
	echo $rss_str; 
}
?>