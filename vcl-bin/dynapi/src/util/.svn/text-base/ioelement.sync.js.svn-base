/*
	DynAPI Distribution
	IOElement SYNChronous add-on

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.

	requires: dynapi.util.IOElement
*/

IOElementSync={}
IOElement.SYNC=true;

var p=IOElement.prototype;

p.activateSyncMode = function(fn,useJava){
	this._SyncFn=fn;
	this._useJava=useJava;
	this._hasXMLHttp=(this._hasXMLHttp==null)? IOElement._hasXMLHttp():this._hasXMLHttp;	
	if (!this.isSync && this._created) {
		window.setTimeout(this+'._initSync()',100);
	}
};
p._syncRequest = function(url,data,method){
	var dataBody;
	var i,mode,rq,rt={value:''},nv=[];
	var id = this._getRandomID(); // create random load ID to ensure no caching		
	if(!this.isSync) return; 
	method=(method+'').toLowerCase();	
	mod=(method=='post'||method=='get')? method:'get';
	url=IOElement.getAbsoluteUrl(url);
	url += ((url.indexOf('?')==-1)? '?' : '&')+'IORequestID='+id+'&IOMethod='+mod;	
	for (i in data) {
		nv[nv.length]=i+'='+((mod!='get')? data[i]:IOElement.URLEncode(data[i]));
	};
	dataBody = nv.join('&');
	if(data && mod=='get') {url+='&'+dataBody;dataBody=null}	
	// get HTTP Request Object
	if(!this._hReq) this._hReq=IOElement._getHttpReq(this._jApplet); 
	rq=this._hReq; rq.open(mod,url,false);
	if (mod=='post') rq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	if(dynapi.ua.ns4) {
		rq.send(dataBody); rt.value=rq.responseText;
	}else {
		eval('try {'
		+' rq.send(dataBody); rt.value=rq.responseText;'
		+'} catch(e) {}');
	}
	if(rq.status!=200) rt.error={code:rq.status,text:'Connection Error : '+rq.statusText};
	return rt;
};
p._initApplet = function(){
	var isJava,doc,scope=this.getScope(this._elmID+'Sync');
	doc=scope.document;
	this._jApplet=doc.applets['loadApplet'];	
	isJava = !(navigator.javaEnabled() && this._jApplet);
	if(isJava) alert('IOElement Error: Java Applet not loaded. Java is not enabled on this browser');
	else{
		this.isSync=true;
		if (typeof(this._SyncFn)=='function') this._SyncFn();
		else eval(this._SyncFn);	
	}
};
p._initSync = function(){
	var evl,ua=dynapi.ua;
	if (this._hasXMLHttp && !this._useJava ) {
		this.isSync=true;
		if (typeof(this._SyncFn)=='function') this._SyncFn();
		else eval(this._SyncFn);	
	}else {
		var t,url,doc;
		var scope=this.getScope(this._elmID+'Sync');
		if(!scope) return;
		url=dynapi.library.path+'util/';
		t='<html><body><applet name="loadApplet" id="loadApplet" codebase="'+url+'" code="url.class" width="1" height="1"></applet></body></html>';
		doc=scope.document;
		doc.open();doc.write(t);doc.close();
		window.setTimeout(this+'._initApplet()',1000); // Allow applet to initialize
	}
};
IOElement._getHttpReq = function(jApplet){
	var o,ua=dynapi.ua;
	if (jApplet) o = new JavaHttpRequest(jApplet);
	else if(IOElement._hasXMLHttp()){
		if (ua.ns) o = new XMLHttpRequest();
		else if (ua.ie) {
			var t='try {o = new ActiveXObject("Microsoft.XMLHTTP");}'
			+'catch(e){o = new ActiveXObject("MSXML2.XMLHTTP");}'
			eval(t);
		}
		
	} 	
	return o;
};
IOElement._hasXMLHttp = function(){
	var state,ua=dynapi.ua;
	// ie for mac,ie4, ns4, ns6.1,x, does not support xmlhttprequest
	// while ns 6.2.x (based on gecko 0.9.4) supports xmlhttprequest but
	// it does not support sending string via send() - only gecko 0.9.7+ can send string
	// netscape 6.x needs the Java-Plugin to support java applets :(
	if(ua.ns && navigator.vendor=='Netscape6') state=false;
	else if(ua.v>4 && (ua.ns||(ua.ie && ua.win32))) state=true;
	return state;
};

// GetAbsoluteURL
IOElement.getAbsoluteUrl=function(url, docUrl) { // inspired by afroAPI urlToAbs()
	if(url && url.indexOf('://')>0) return url;
	docUrl=(docUrl)? docUrl.substring(0,docUrl.lastIndexOf('/')+1):dynapi.documentPath;
	url=url.replace(/^(.\/)*/,'');
	docUrl=docUrl.replace(/(\?.*)$/,'').replace(/(#.*)*$/,'').replace(/[^\/]*$/,'');
	if (url.indexOf('/')==0) return docUrl.substring(0,docUrl.indexOf('/',docUrl.indexOf('//')+2))+url;
	else while(url.indexOf('../')==0){
		url=url.replace(/^..\//,'');
		docUrl=docUrl.replace(/([^\/]+[\/][^\/]*)$/,'');
	};
	return docUrl+url;
};

// Java Base HttpRequest 
JavaHttpRequest = function(jApplet){
	this.applet=jApplet;
	this.url = "";
	this.responseText = "";  
	this.status=200;this.statusText="";
};
var jhr = JavaHttpRequest.prototype;
jhr.setRequestHeader = function(){}; //dummy
jhr.open = function(method,url){
  this.url = url;
  this.method = (method||'get');
};
jhr.send = function(data){
	var r,url=this.url;
	if (url=="") return false;
	
	this.responseText = "";
	if (this.applet){
		this.status=200;this.statusText="";
		if(!url.indexOf('file:///') && url.indexOf('file://')) url='file:///'+url.substr(7);
		r=this.applet.readURL(url, true, data||"", dynapi.documentPath);
		if(r) {
			r=new String(r);
			r=r.replace(/\n$/,'');
			if(r.indexOf('Error: ')==0) {
				this.status='403';
				this.statusText=r.substr(7);
			}
			this.responseText=r;
		}
		return true;
	}
};

