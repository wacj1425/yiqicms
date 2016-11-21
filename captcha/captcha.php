<?php
session_start();
Header("Content-type: image/PNG");
$im = imagecreate(80,30);
$back = ImageColorAllocate($im, 245,245,245);
imagefill($im,0,0,$back);
$vcodes = '';
srand((double)microtime()*1000000);
$textarr = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
for($i=0;$i<4;$i++){
$font = ImageColorAllocate($im, rand(100,255),rand(0,100),rand(100,255));
$authnum=rand(0,(count($textarr)-1));
$vcodes.=$textarr[$authnum];
imagestring($im, 8, 6+$i*20, 8, $textarr[$authnum], $font);
}

for($i=0;$i<100;$i++)
{ 
$randcolor = ImageColorallocate($im,rand(0,255),rand(0,255),rand(0,255));
imagesetpixel($im, rand()%70 , rand()%30 , $randcolor);
} 
ImagePNG($im);
ImageDestroy($im);
$_SESSION['captcha'] = strtolower($vcodes);
?>