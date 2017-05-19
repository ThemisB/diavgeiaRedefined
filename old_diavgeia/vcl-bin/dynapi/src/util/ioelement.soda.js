/*
	DynAPI Distribution
	IOElement SODA add-on

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.

	requires: Math, IOElement
*/

IOElementSoda={}; // used by dynapi.library
IOElement.SODA=true;

var p=IOElement.prototype;

p.createWebService = function(name,url,fn,useSync,uid,pwd,method){
	var o,IOE=IOElement;
	if(typeof(fn)!='function') {
		alert('Missing or invalid Callback Function');
		return;
	}
	
	useSync=(IOElement.SYNC)? useSync:false;	
	o=this[name]={};
	method=(method+'').toLowerCase();
	o.sid=dynapi.functions.getGUID();
	o._callback=fn;
	o._name=name;
	o._useSync=useSync;
	o._method=(method=='post'||method=='get')? method:'post';
	o._src=this; o._url=url; o._uid=uid; o._pwd=pwd;
	o._iSysCall=IOE.ws_iSysCall;
	o._iSysManager=IOE.ws_iSysManager;
	o._iSysConnect=IOE.ws_iSysConnect;

	o.isConnected=false;
	o.call=IOE.ws_callSrv;
	o.getWebName=IOE.ws_getWebName;
	o.getWebComment=IOE.ws_getWebComment;
	o.importWebMethods=IOE.ws_importWebMethods;

	if(!useSync || (useSync && this.isSync)) o._iSysManager("connect");
	else this.activateSyncMode(this+'.'+name+'._iSysManager("connect")');
};
p.disconnectWebService = function(name,fn){
	var o=this[name];
	if(o && o._src==this && o.isConnected==true){
		o._callback=fn;
		o._iSysManager("disconnect");
	};
};
p.getResponse = function(){
	var cargo=this.getCargo(true);
	var retry=(this._retryID==this._cargoID)?true:false;
	var response=IOElement.ws_SODAParser(this.getVariable('wsSODAResponse'));
	if(retry) response.error={code:0,text:'Request Timeout'};
	if(response.error) this._retryID=this._cargoID;
	if(cargo) response.serviceName=cargo.DynAPIWSName;
	return response;
};

// WS Object Functions
IOElement.wsError='Error occurred while parsing SODA Envelope';
IOElement.ws_iSysManager = function(sys){
	var s,r;
	
	this.isSync = (this._useSync && this._src.isSync)? true:false;;	
	
	if(sys=='connect') mn='SYS:WebServiceConnect';
	else if(sys=='disconnect') mn='SYS:WebServiceDisconnect';
	
	if(this.isSync) { 
		// use sync login/logout
		r=this._iSysCall(mn);			
		o=r.value;	
		if(o && typeof(o)=='object' && o.SYSCall==true) {
			o.error=r.error;
			r=o;s=true;
		};	
		this._iSysConnect(r,s);
	}else { 
		// use async login/logout
		var cargo={wsObject:this,DynAPIWSName:this._name}
		this._iSysCall(mn,null,this._iSysConnect,cargo);
	}
};
IOElement.ws_iSysConnect = function(e,s){
	var o,r,c,ws,et;

	if(!e||(e && e.constructor!=DynEvent)) {
		// sync
		o=ws=this; 
		if(!e.error) c=e;
		else if(e.error) et= ((e.error.code)? e.error.code+':':'')+e.error.text;
		else if(!s) et='Connection Failed';
	}else{
		// async
		o=e.getSource();
		r=o.getResponse();
		c=o.getCargo(!s||!r.value);
		o=ws=c.wsObject;
		c=r.value;
		if(r.error) et=r.error.text;
	}
	o.isConnected=false;
	if(!et && c && (c.logout||c.login)=='failed') et='Login failed';
	s=(!et && c && (c.logout||c.login)=='ok')? true:false; // web service must return a login/logout state
	if(s && c.logout) {
		delete o._src[o._name];
		o.call=dynapi.functions.Null;
	}else if(s && c.login){
		o._iWSName = c.name;
		o._iWSComment = c.comment;
		o._iWSMethodNames = (c.methodNames)? c.methodNames:'';
		o.isConnected=s;
	}
	if (o._callback) o._callback(ws,s,et);
};

IOElement.ws_iSysCall=function(name,params,fn,cargo){ // used to make async/sync system call to the service
	var r,o,data={};
	if(this.isSync) fn=false;
	data.IOResponse=(fn)? 'text/html':'text/xml';
	data.IOEnvelope=IOElement.ws_createSODAEnvelope(name,params,null,null,this.sid,this._uid,this._pwd);
	if(this._method=='get') r=this._src.get(this._url,data,fn,cargo);
	else r=this._src.post(this._url,data,fn,cargo);
	if(this.isSync) {
		// convert SODA text returned from get() or post() into response object 
		if(!r.error) r=IOElement.ws_SODAParser(r.value);
	}
	return r;
};

IOElement.ws_callSrv=function(name,params,fn,cargo){
	var rt,data={IOResponse:'text/html'},cargo=(cargo)? cargo:{};
	var mod=this._method;
	var sync=(fn==false && this.isSync);
	if(typeof(name)!='string'){
		var i,o=name;
		var na=[],pa=[];
		for(i in o){
			na[na.length]=i;
			pa[pa.length]=o[i];
		}
		name=na.join(',');
		params=pa;
	}
	if(typeof(params)!='object'||params==null) params=[params];
	else if((params.constructor+'')!= (Array+'')) params=[params];
	IOElement.ws_setStringEncFormat('xml');
	cargo.DynAPIWSName=this._name;
	data.IOEnvelope=IOElement.ws_createSODAEnvelope(name,params,null,null,this.sid);
	if(sync) data.IOResponse = 'text/xml'; // Returned Content Format
	if (mod=='get') rt=this._src.get(this._url,data,fn,cargo);
	else rt=this._src.post(this._url,data,fn,cargo);
	if(sync) {	
		// convert SODA text returned from get() or post() into response object 
		if(!rt.error) rt = IOElement.ws_SODAParser(rt.value);		
		rt.serviceName=this._name;
	}
	return rt;
};
IOElement.ws_createSODAEnvelope = function(method,body,ecode,etext,sid,uid,pwd){
	return '<envelope>'
	+((sid)? '<sid>'+ sid +'</sid>':'')
	+((ecode||etext)? '<err>'+ IOElement.ws_SODAStringEncode(ecode+'|'+etext) +'</err>':'')
	+((uid)? '<uid>'+uid+'</uid>':'')
	+((pwd)? '<pwd>'+pwd+'</pwd>':'')
	+'<method>'+ IOElement.ws_SODAStringEncode(method) +'</method>'
	+'<body>'+ IOElement.ws_Var2SODA(body) +'</body>'
	+'</envelope>';	
};
IOElement.ws_getWebName= function(){	
	return this._iWSName;
};
IOElement.ws_getWebComment= function(){	
	return this._iWSComment;
};
IOElement.ws_importWebMethods = function(){	
	if(!this.isSync) return false;
	var fn,rt=this._iWSMethodNames;
	if(rt) {
		rt=rt.split(',');
		for(var i=0;i<rt.length;i++){
			fn=rt[i];
			s = 'var mthd="'+fn+'";'
				+'var i,params=(arguments.length)?[]:null;'
				+'for(i=0;i<arguments.length;i++){params[i]=arguments[i]};'
				+'return this.call(mthd,params,false);';
			this[fn]=new Function('',s);
		}
		return true;
	}
};

// SODA Internal Data types: U=undefined/null, I=integer, F=float, B=boolean, D=date/time, S=string, A=array, O=Object (Associative Array)
IOElement._strEncFormat='xml'; // String Encode Format: html or xml
IOElement.ws_Var2SODA=function(v,lvl){
	var ot,ct,i,c,data,vtype=typeof(v);

	if (lvl>=0) lvl++;
	else lvl=0;

	if(vtype=="number") {
		if((v+'').indexOf('.')>=0) data='<f'+lvl+'>'+v+'</f'+lvl+'>';
		else data='<i'+lvl+'>'+v+'</i'+lvl+'>';
	}else if(vtype=="boolean") {
		if(v==true) data='<b'+lvl+'>true</b'+lvl+'>';
		else data='<b'+lvl+'>false</b'+lvl+'>';
	}else if(vtype=="string") {
		data='<s'+lvl+'>'+this.ws_SODAStringEncode(v)+'</s'+lvl+'>';
	}else if(vtype=="object" && v!=null) {
		if((v.constructor+'')==(Array+'')){
			data='<a'+lvl+'>';
			for (i=0;i<v.length;i++){
				data+=(i>0)? '<r'+lvl+'/>'+this.ws_Var2SODA(v[i],lvl):this.ws_Var2SODA(v[i],lvl);
			}
			data+='</a'+lvl+'>';
		}else if((v.constructor+'')==(Date+'')){
			//Date format: mm/dd/yyyy hh:nn:ss
			v=((v.getMonth()+1)+'/'+v.getDate()+'/'+v.getFullYear()+' '+v.getHours()+':'+v.getMinutes()+':'+v.getSeconds());
			data='<d'+lvl+'>'+v+'</d'+lvl+'>';
		}else {
			var keys=[],values=[];
			for(var key in v){
				values[values.length]=v[key];				
				if (key.indexOf('|')>=0) key=key.replace(/\|/g,'&s;');
				keys[keys.length]=key;
			}
			v=[keys.join('|'),values];
			data='<o'+lvl+'>'+this.ws_Var2SODA(v,lvl)+'</o'+lvl+'>';
		};
	}else data='<u'+lvl+'>0</u'+lvl+'>';
	if (lvl==0) data='<soda>'+data+'</soda>';
	return data;
};
IOElement.ws_SODA2Var=function(t,lvl){
	var i,tag,data,elms;
	var tagType,tagIndex;

	if (lvl>=0)lvl++;
	else lvl=0;

	if(lvl==0) {
		if((t+'').substr(0,6)!='<soda>') return t;
		tag=IOElement.ws_getSODATag(t,'soda');
		t=tag.content;
	}

	tag=this.ws_getSODATag(t);
	tagType=tag.name.substr(0,1);
	tagIndex=tag.name.substr(1);
	if(tagType=='i') data=parseInt(tag.content);
	else if(tagType=='f') data=parseFloat(tag.content);
	else if(tagType=='b') data=(tag.content=='true')?true:false;
	else if(tagType=='s') data=IOElement.ws_SODAStringDecode(tag.content+'');
	else if(tagType=='d') data= new Date(tag.content);
	else if(tagType=='a') {
		data=[];
		if(tag.content){
			elms=tag.content.split('<r'+tagIndex+'/>');
			for (i=0;i<elms.length;i++){
				data[i]=this.ws_SODA2Var(elms[i],lvl);
			}
		}
	}else if(tagType=='o') {
		data={};
		elms=this.ws_SODA2Var(tag.content,lvl);
		if(!elms) elms=[];
		var key,keys=(elms[0]+'').split('|');
		var values=elms[1];
		for (i=0;i<keys.length;i++) {
			key=keys[i];
			if(key.indexOf('&s;')>=0) key=key.replace(/\&s\;/g,'|');
			data[key]=values[i];
		}
	}else if(tagType=='u') data=null;
	return data;
};
IOElement.ws_SODAStringEncode=function (text){
	if (!text) return '';
	// encode string for use with html/javascript
	if(this._strEncFormat=='html'){
		text=text.replace(/\\/g,"\\\\");	//  \ -> \\
		text=text.replace(/\'/g,"\\'");		// ' -> \'   "
		text=text.replace(/\n/g,"\\n");
		text=text.replace(/\r/g,"\\r");
	}
	// encode string for use with xml/html
	text=text.replace(/\&/g,"&amp;");
	text=text.replace(/</g,"&lt;");
	text=text.replace(/>/g,"&gt;");
	return text;
};
IOElement.ws_SODAStringDecode=function (text){
	if (!text) return '';
	text=text.replace(/\&amp\;/g,"&");
	text=text.replace(/\&lt\;/g,"<");
	text=text.replace(/\&gt\;/g,">");
	return text;
};
IOElement.ws_setStringEncFormat = function(t){
	this._strEncFormat=(t=='xml')? 'xml':'html';
};
IOElement.ws_getSODATag=function(t,n){
	var st,et,tag,con;
	if(!t) return {};
	n=(n)?n:'';
	st=t.indexOf('<'+n);
	et=t.indexOf('>',st);
	if(st || et) {
		tag=t.substr(st+1,(et-1)-st);
		st=et+1;
		et=t.indexOf('</'+tag+'>');
		con=t.substr(st,et-st);

	}
	return {name:tag,content:con};
};
IOElement.ws_SODAParser=function(envelope){
	var r={
		error:IOElement.ws_SODAStringDecode(IOElement.ws_getSODATag(envelope,'err').content),
		methodName:IOElement.ws_SODAStringDecode(IOElement.ws_getSODATag(envelope,'method').content),
		value:IOElement.ws_SODA2Var(IOElement.ws_getSODATag(envelope,'body').content)
	};
	if(r.error) {
		var ea=r.error.split('|');
		r.error={code:ea[0],text:ea[1]};
	}else if((envelope+'').indexOf('<envelope>')!=0){
		r.error={code:'E3',text:IOElement.wsError+':\n\n'+envelope};
	};
	return r;
};
