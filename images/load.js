$(function(){
	$("#slt").click(function(){
	    $("input[name='chk[]']").each(function(){
	        $(this).attr("checked",!this.checked);});
	});
});