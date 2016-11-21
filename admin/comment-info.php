<?php
require_once 'admin.inc.php';
require_once '../include/comments.class.php';

$cid = $_GET["cid"];
$cid = (isset($cid) && is_numeric($cid)) ? $cid : 0;

$commentdata = new Comments;
$commentinfo = $commentdata->GetComment($cid);
if($commentinfo==null)
{
    header("location:comments.php");exit();
}
?>
<?php
$adminpagetitle = "查看留言";
include("admin.header.php");?>
<div class="main_body">
<table class="inputform" cellpadding="1" cellspacing="1">
<tr><td class="label">留言标题</td><td class="input"><?php echo $commentinfo->title;?></td></tr>
<tr><td class="label">留言人</td><td class="input"><?php echo $commentinfo->name;?></td></tr>
<tr><td class="label">联系方式</td><td class="input"><?php echo $commentinfo->contact;?></td></tr>
<tr><td class="label">留言内容</td><td class="input"><?php echo $commentinfo->content;?></td></tr>
<tr><td class="label">留言时间</td><td class="input"><?php echo $commentinfo->adddate;?></td></tr>
</table>
</div>

</div>

<div class="clear">&nbsp;</div>
<?php include("admin.footer.php");?>
</div>
</body>

</html>