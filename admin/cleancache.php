<?php
require_once ('../include/common.inc.php');
require_once ('../include/templets.class.php');
$tempinfo = new Templets();
$tempinfo->compile_dir = YIQIROOT.'/cache/compile/';
$tempinfo->clear_compiled_tpl();
ShowMsg("缓存清除成功！","back");
?>