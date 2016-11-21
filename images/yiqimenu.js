$.fn.yiqimenu = function(){
	this.each(function(){
		$("dd").hide();
		$("dt a").click(function(){
			if ($.css(this, "display") !== "none" && $.css(this,"visibility") !== "hidden")
			{
				$("dd").show();
				$("dd:visible").hide();
				$(this).parent().next().show();
				$(this).parent().next().show();
				
			}return false;
		});
		return this;
	});
};