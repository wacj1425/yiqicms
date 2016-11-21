J.focusPic=function(f){

	var f=document.getElementById(f);
	var a=f.getElementsByTagName('a');
	var by=document.createElement('div');

	var order=0;
	with(f.style){overflow='hidden';position='relative';}
	with(by.style){position='absolute';right='10px';bottom='10px';zIndex=1000}

	if(a){
		for(i=0;i<=a.length-1;i++){
			with(a.item(i).style){position='absolute';zIndex=1}
			n=i+1;
			var span=document.createElement('span');
			with(span.style){
				width='14px';height='14px';lineHeight='14px';textAlign='center';background='#000';color='#fff';display='inline-block';
				borderRadius='3px';fontSize='12px';cursor='pointer';margin='0 3px';fontFamily='黑体'}
			span.innerHTML=n;
			span.setAttribute('n',i);
			by.appendChild(span);
		}
	}

	f.appendChild(by);
	var span=by.getElementsByTagName('span');
	btn(order);

	//为所有数字按钮添加鼠标事
	for(i=0;i<=a.length-1;i++){
		span.item(i).onmouseover=function(){o=parseInt(this.getAttribute('n'));btn(o)}
		span.item(i).onclick=function(){order=parseInt(this.getAttribute('n'));btn(order);anam(order);clearInterval(play);play=window.setInterval(auto,3000)}
	}

	//自动播放
	var play=window.setInterval(auto,3000);
	var level=a.length;
	function auto(){order+=1;if(order>a.length-1)order=0;btn(order);anam(order)}

	//按钮切换
	function btn(id){
		for(i=0;i<=span.length-1;i++){with(span.item(i).style){background='#000';color='#fff'}}
		with(span.item(id).style){background='#fff';color='#000'}
	}

	//焦点图切换
	function anam(id){
		with(a.item(id).style){level+=1;zIndex=level;filter='alpha(opacity=0)';opacity='0';by.style.zIndex=level+1;}
		var opa=0;
		var alpha=window.setInterval(function(){
			opa+=5;
			if(opa>100)window.clearInterval(alpha);
			with(a.item(id).style){filter='alpha(opacity='+opa+')';opacity=opa/100;}
		},50);
	}

}



