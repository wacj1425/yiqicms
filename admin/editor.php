<?php 
function editor($editorname='kindeditor',$container='articlecontent'){
	if ($editorname=='kindeditor') {
?>
<div class="addinfo">	
	字数统计：<span class="word_count"></span> 个 <span class="note"></span>
</div>
<link rel="stylesheet" href="./kindeditor/default/default.css"/>
<script type="text/javascript" src="./kindeditor/kindeditor-min.js"></script>
<script type="text/javascript" src="./kindeditor/lang/zh_CN.js"></script>
<style type="text/css">
	.ke-icon-paging{
		width: 16px;
		height: 16px;
	}
</style>
<script type="text/javascript">
	KindEditor.lang({
		paging : '插入分页符'
	});
	KindEditor.plugin('paging', function(K) {
		var self = this, name = 'paging';
		self.clickToolbar(name, function() {
			self.insertHtml('<br/>{!--page--}<br/>');
		});
	});
	KindEditor.ready(function(K){
		var editor=K.create('textarea[name="<?php echo $container;?>"]',{
			width:"100%",
			resizeType : 1,
			items : [
				'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
				'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
				'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
				'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', 
				'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
				'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'multiimage',
				'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
				'anchor', 'link', 'unlink','|','paging'
			],
			afterChange:function(){
				K('.word_count').html(this.count('text'));
				var key_c=$(".word_count").text();
				if (key_c > 800) {
					$(".addinfo>span.note").text("输入字数已经超过800建议进行分页");
				}else{
					$(".addinfo>span.note").text('');
				}
			}
		});
		$("#getthumb").click(function(){
			var imgSrcRegex=/<img.*?src="(.*?)"/;
			var match = imgSrcRegex.exec(editor.html());
			if (match) {
				$("input[name^='thumb']").val(match[1]);
				alert("缩略图获取成功");
			}else{
				$("input[name^='thumb']").val('');
				alert("获取缩略图失败");
			};
		});
		$("#getkeywords").click(function(){
			$.post('api.php',{"action":"getKeywordsStr","content":editor.text()},function(data){
				if (data.st!=0) {
					$("input[name$='keywords']").val(data.str);
				};
			},"json");
		});
	});
</script>
<?php
	}elseif($editorname=='tiny_mce'){
?>
<script type="text/javascript" src="tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript">
	$().ready(function(){
		$("#contentform").tinymce({
			// Location of TinyMCE script
			script_url : 'tiny_mce/tiny_mce.js',

			// General options
			theme : "advanced",
			language : "zh",
			width : "580",
			height : "360",
			add_unload_trigger : true,
			plugins : "Ybrowser,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "undo,redo,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "forecolor,backcolor,del,ins,|,cut,copy,paste,pastetext,pasteword,|,outdent,indent,attribs,table,|,link,unlink,anchor,image,Ybrowser,media,cleanup,|,preview,code,fullscreen",
			theme_advanced_buttons3 : "",
			theme_advanced_buttons4 : "",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : false,
			
			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",
			relative_urls : false,
			convert_urls :true,
			remove_script_host : false
		});
	})
</script>
<?php
	}
}
 ?>