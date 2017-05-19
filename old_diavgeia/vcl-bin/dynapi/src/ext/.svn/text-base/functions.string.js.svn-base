/*
	DynAPI Distribution
	dynapi.functions.String extension	
*/

var f = dynapi.functions;
f.String = {}; // used by dynapi.library


// String Functions --------------------------------

f.sprintf = function(t){
	var ar = arguments;
	var i=1,inx = t.indexOf("%s");
	while(inx>=0){
		t = t.substr(0, inx) + ar[i++] + t.substr(inx+2);
		inx = t.indexOf("%s");
	}
	return t;
};
f.strRepeat = function(s,n) {
	if(!s) return '';
	var i,a=[];
	for(i=1;i<=n;i++){
		a[a.length]=s;
	}
	return a.join('');
};
f.strReverse = function(s) {
	if(!s) return '';
	var a=(s+'').split('');
	a.reverse();
	return a.join('');
};
f.strStuff = function(s,v,index) {
	if(!s) return '';	
	if (index==null) s=s+v+'';
	else {
		var t1=t2=s+'';
		s=t1.substr(0,index)+v+t2.substr(index,t2.length-index);
	}
	return s;
};
f.trim = function(s,dir){
	if(!s) return;
	else s+=''; // make sure s is a string
	dir=(dir)? dir:'<>';
	if(dir=='<'||dir=='<>') s=s.replace(/^(\s+)/g,'');
	if(dir=='>'||dir=='<>') s=s.replace(/(\s+)$/g,'');
	return s;
	
};