<?php 
header('Content-Type:text/html;charset=utf-8');
if (@$_POST['action']=='save') {
	require_once '../include/upload.class.php';
	$config = array(
			'maxSize'    =>    3145728,
			'rootPath'   =>    '../uploads/',
			'savePath'   =>    'image/',
			'saveName'   =>    array('uniqid',''),
			'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
			'autoSub'    =>    true,
			'subName'    =>    array('date','Ymd'),
		);
	$upfile=new Upload($config);
	var_dump($upfile->upload());
	exit();
}
 ?>
 <form action="" method="post" enctype="multipart/form-data" accept-charset="utf-8">
 	<input type="file" name='thumb[]'/>
 	<input type="hidden" name='action' value='save'/>
 	<button type="submit">提交</button>
 </form>