/*
   DynAPI Distribution
   Cookie functions

   The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
*/ 

/*
This is not tested, should work like this:

		var c = new Cookie('mycookieset');
		c.add('array',[1,2,3]); // re-saves cookie each time a value is added
		
		var c = new Cookie('mycookieset');  // auto-retrieves saved cookie object
		var name = c.get('name');
		var array = c.get('array');
		array[array.length] = 4;
		c.add('name',name+' MyLastName');
		c.add('array',array);
*/


function Cookie(name,pDType) {
	this.DynObject = DynObject;
	this.DynObject();
	
	this.data = {};
	this.name = name;
	this.exists = false;
	this._pdt=pDType;
	var c = dynapi.functions.getCookie(this.name);
	if (c) {
		this.exists = true;
		var a = c.split(',');
		var x,n,v;
		for (var i=0;i<a.length;i++) {
			x = a[i].split('=');
			n = x[0];
			v = Cookie.decode(x[1]);
			if (n && v) this.data[n] = v;
		}
		//var i1 = c.indexOf('expires=');
		this._save(false);
	}
	else this._save();
};
// to-do: replace escape(),unescape() with better encoding functions
Cookie.decode = function(t,_lvl){
	var dt = (t+'').substring(0,2);
	if(isNaN(_lvl)) _lvl=0; else _lvl++;
	if(dt=='a[') {			//array
		t=t.substring(2,t.length-1);
		t=t.split('\\'+_lvl);
		for(var i=0;i<t.length;i++) t[i]=Cookie.decode(t[i],_lvl);
	}
	else if(dt=='o[') {	//object
		var a,n,v;
		t=t.substring(2,t.length-1);
		a=t.split('\\'+_lvl);
		t={};
		for(var i=0;i<a.length;i++) {
			n=a[i].substring(0,a[i].indexOf(':'));
			if(n) v=a[i].substring(n.length+1);
			else v=null;
			t[n]=Cookie.decode(v,_lvl);
		}
	}
	else if(dt=='n[') {	//number:float, integer
		t=parseFloat(t.substring(2,t.length-1));
	}
	else if(dt=='d[') {	//date
		t=new Date(unescape(t.substring(2,t.length-1)));
	}
	else if(dt=='b[') {	//boolean
		t=(t.substring(2,t.length-1)=="1")? true:false;
	}
	else if(dt=='u[') {	//null
		t=null;	
	}
	else{				//string
		t=unescape(t);
	}
	return t;
};
// to-do: replace escape(),unescape() with better encoding functions
Cookie.encode = function(t,pDType,_lvl){
	if (!pDType) t=escape(t);
	else if (t==null) t='u[]';
	else if(typeof(t)=='number') t='n['+t+']';
	else if(typeof(t)=='boolean') t='b['+((t)? 1:0)+']';
	else if(typeof(t)!='object') t=escape(t);
	else {
		if(isNaN(_lvl)) _lvl=0; else _lvl++;
		if(t.constructor==Date) t='d['+escape(t)+']';
		else if(t.constructor==Array){	
			//encode array = a[n1\0n2...\0nN]
			var a=[];
			for(var i=0;i<t.length;i++) a[i]=Cookie.encode(t[i],pDType);			
			t='a['+a.join('\\'+_lvl)+']';
		}
		else {							
			//encode object = o[name1:value1\0name2:value2...\0nameN:valueN]
			var a=[];
			for(var i in t){
				a[a.length]=(i+':'+Cookie.encode(t[i],pDType,_lvl));
			}
			t='o['+a.join('\\'+_lvl)+']';
		}
	}
	return t;
};
var p = dynapi.setPrototype('Cookie','DynObject');
p.get = function(name) {
	return this.data[name];
};
p.getAll = function() {
	return data;
};
p.add = function(name,value) {
	this.data[name] = value;
	this._save();
};
p.remove = function(name) {
	this.data[name] = null;
	delete this.data[name];
	this._save();
};
p.removeAll = function(){
	this.data = {};
	this._save();
};
p.setExpires = function(days) {
	this.expires = days;
};
p.destroy = function() {
	dynapi.functions.deleteCookie(this.name);
};
p._save = function(write) {
	var s = '';
	for (var i in this.data) {
		var v = this.data[i];
		if (v) s += i + '=' + Cookie.encode(v,this._pdt) + ',';
	}
	s = s.substring(0,s.length-1);
	var f = 'Saved';
	if (write!=false) dynapi.functions.setCookie(this.name,s,this.expires);
	else f = 'Found';
	dynapi.debug.print(f+' Cookie: name='+this.name+' data={'+s+'}');
};

dynapi.functions.setCookie = function(name,value,days) {
	if (days) {
		var date=new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires="; expires="+date.toGMTString();
	} 
	else expires = "";
	dynapi.frame.document.cookie = name+"="+value+expires+"; path=/";
};
dynapi.functions.getCookie = function(name) {
	var nameEQ = name+"=";
	var c,ca = dynapi.frame.document.cookie.split(';');
	for(var i=0;i<ca.length;i++) {
		c=ca[i];
		while (c.charAt(0)==' ') c=c.substring(1,c.length);
		if (c.indexOf(nameEQ)==0) return c.substring(nameEQ.length,c.length);
	}
	return null;
};
dynapi.functions.deleteCookie = function(name) {
	dynapi.functions.setCookie(name,"",-1);
};
