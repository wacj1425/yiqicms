<?php
session_start();
$_SESSION["adminid"] = null;
exit('您已经安全退出，您现在可以返回 <a href="../">网站首页</a> 或 <a href="login.php">重新登录</a>');
?>
