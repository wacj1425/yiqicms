<?php
 /**
  * Smarty plugin
  * @package Smarty
  * @subpackage plugins
  */
 

/**
  * Smarty truncate modifier plugin
  *
  * Type:     modifier<br>
  * Name:     truncate<br>
  * Purpose:  Truncate a string to a certain length if necessary,
  *           optionally splitting in the middle of a word, and
  *           appending the $etc string or inserting $etc into the middle.
  * @param string
  * @param integer
  * @param string
  * @param boolean $keep_first_style
  * @return string

*/
 
function smarty_modifier_truncate($string, $strlen = 20, $etc = '...',
                                   $keep_first_style = false)
 {
    return cutstr($string,$strlen,$etc);  
}

function cutstr($string, $length, $dot = ' ...') {
	$charset = 'utf-8';
	if(strlen($string) <= $length) {
		return $string;
	}
	$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);
	$strcut = '';
	if(strtolower($charset) == 'utf-8') {
		$n = $tn = $noc = 0;
		while($n < strlen($string)) {
			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t <= 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}
			if($noc >= $length) {
				break;
			}
		}
		if($noc > $length) {
			$n -= $tn;
		}
		$strcut = substr($string, 0, $n);
	} else {
		for($i = 0; $i < $length; $i++) {
			$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
		}
	}
	$strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);
	return $strcut.$dot;
}
 
/* vim: set expandtab: */
 
?>
