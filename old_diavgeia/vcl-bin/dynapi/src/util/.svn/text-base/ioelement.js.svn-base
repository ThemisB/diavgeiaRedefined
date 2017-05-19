/*
	DynAPI Distribution
	IOElement Class

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.

	requires: dynapi.api.DynLayer

	// pages loaded must include this code:
	<script>
		if (parent.dynapi) parent.IOElement.notify(this);
	</script>
*/

function IOElement(hiddenThreads,useXFrames) {
	this.DynLayer = DynLayer;
	this.DynLayer();

	this._elmID = this.id+'elm';
	this._requests = {};	// [url,data,fn,method,elmThread,timer,cargo]
	this._cargoID='';
	this._requestList = [];
	this._requestIndex = -1;
	this._retryID=null;
	this._transactions = {};

	this._singleThread=false;
	this._elmBusy=[];
	this._elmThread=null;
	this._maxThreads=(hiddenThreads>=1 && hiddenThreads<=8)? hiddenThreads : 1;
	this._hidden = (hiddenThreads)? true : false;

	this.isSync=false;
	this.failTime = 50000;

	// create XFrame window
	if(useXFrames && dynapi.ua.ns4) {
		this._winXFrames=window.open("about:blank",null,'left=3000,top=3000,width=100,height=100,scrollbars=no,status=no,toolbar=no');
		this._winXFrames.blur(); // hide the new window
		var wxf=this._winXFrames;
		dynapi.onUnload(function() { // tidy up
			if(wxf.open && !wxf.closed) wxf.close();
		});
	}

	if (this._hidden) {
		var o = this;
		o.setLocation(1,1);// Strange! ns4 requires that the x,y be set in order to load the java applet inside the layer
		o.setVisible(false);
		dynapi.document.addChild(o);
	}

	this.onPreCreate(IOElement.fnPrecreate);
	this.onCreate(IOElement.fnCreate);
};

IOElement.fnPrecreate = function() {
	var t,r=['*'],html=[];
	if (this._hidden) {
		if (this._winXFrames) html = ['<frame src="about:blank" name="',this._elmID,'" scrolling="none">'];
		else if (dynapi.ua.ns4) html = ['<ilayer name="',this._elmID,'" visibility="hide" width=0 height=0></ilayer>'];
		else {
			// Opera v7.11 requires an IFrame's src to be set before it's accessible - pixel.gif is a 1x1 transparent gif
			html = ['<iframe name="',this._elmID,'" src="'+dynapi.library.path+'gui/images/pixel.gif" style="width:0px; height:0px; visibility:hidden"></iframe>'];
		}
		t=html.join('');
		this._elmThread=this._elmID;
		this._elmBusy[this._elmID]=false;
		for(var i=1;i<this._maxThreads;i++){ // setup additional threads
			r[i]='*';// for XFrames
			html[1]=this._elmID+'x'+i;
			t+=html.join('');
			this._elmBusy[this._elmID+'x'+i]=false; // flag as not busy
		}
		// java-sync frame
		html[1]=this._elmID+'Sync';
		t+=html.join('');
	}else{
		if (this._winXFrames) t = '<frame src="about:blank" name="',this._elmID,'" scrolling="none">';
		else if (dynapi.ua.ns4) t = '<ilayer width='+this.w+' height='+this.h+' name="'+this._elmID+'" visibility="inherit"></ilayer>';
		else t = '<iframe name="'+this._elmID+'" width='+this.w+' height='+this.h+' scrolling="no" frameborder="no" marginwidth=0 marginheight=0 style="overflow:hidden;"></iframe>';
		this._elmThread=this._elmID; this._elmBusy[this._elmID]=false;
	}

	if (!this._winXFrames) this.html=t;
	else{
		var src='<html><head><title>DynAPI XFrame</title></head>\n'
		+'<frameset rows="'+r.join(',')+',0">\n'+t
		+'</frameset></html>\n'
		this._winXFrames.document.open();
		this._winXFrames.document.write(src);
		this._winXFrames.document.close();
		this._winXFrames.top.dynapi=dynapi;
		this._winXFrames.top.IOElement=IOElement;
	}
};
IOElement.fnCreate = function() {
	if (this._SyncFn) window.setTimeout(this+'._initSync()',100);
	if (this.getScope()) {
		if (this._requestList.length>0) {
			this._setRequestTimeout(100);
		}
	}
};

var p = dynapi.setPrototype('IOElement','DynLayer');
p.execInParent = function(fn){	// Executes javascript codes within the parent element
	if(typeof(fn)=='function') eval('fn='+fn);
	else eval('fn=function(){'+fn+'}');
	fn();
};
p.getVariable = function(name) {
	var v=this.getScope()[name];
	if (IOElement.SODA) v=IOElement.ws_SODA2Var(v);
	return v;
};
p.getScope = function(thread) {
	var scope;
	if (!thread) thread=this._elmThread;
	if (this._winXFrames && this._winXFrames.top) scope = this._winXFrames.top.frames[thread];
	else if (dynapi.ua.ns4) scope = this.doc.layers[thread];
	else scope = window.frames[thread];
	if (!scope) return alert('IOElement Error: no load element');
	else return scope;
};
p.getCargoID=function(){return this._cargoID}
p.getCargo=function(dontRemove){
	if(!this._cargoID) return null;
	var c=this._requests[this._cargoID][6];
	if(!dontRemove) {
		// normal cargo are removed from storage
		this._requests[this._cargoID][6]=null;
	}
	return c;
};
p.isBusy = function(){
	for (var i in this._elmBusy){
		if (this._elmBusy[i]==false) return false;
	};return true;
};
p.cancel= function(id){
	id=(id)? id:this._retryID;
	var req=this._requests[id];
	if(req){
		this._elmBusy[req[4]]=false;
		delete this._requests[id];
		this._clearScope();
		return true;
	}
};
p.cancelAll=function(){
	this._requests={};
	for (var i in this._elmBusy){
		this.elmThread=i;
		this._clearScope();
	}
};
p.retry=function(id){
	id=this._retryID=((id)? id:this._retryID);
	var req=this._requests[id];
	if(req)	{
		this._setRequestTimeout(50,id);
		return true;
	}
};
p.setTimeout = function(ms){
	if(!isNaN(ms))this.failTime=ms;
}
p.useSingleThread = function(b){
	this._singleThread=b;
};
p.get = function(url,data,fn,cargo) {
	if(fn==false && this.isSync) return this._syncRequest(url,data,'get');
	else return this._asyncRequest(url,data,fn,'get',cargo);
};
p.post = function(url,data,fn,cargo) {
	if(fn==false && this.isSync) return this._syncRequest(url,data,'post');
	return this._asyncRequest(url,data,fn,'post',cargo);
};
p.upload=function(url,form,fn,cargo){	// file upload
	return this._asyncRequest(url,form,fn,'upload',cargo);
};
p._asyncRequest = function(url,data,fn,method,cargo) {
	var i,l,src;
	var id = this._getRandomID(); // create random load ID to ensure no caching
	dynapi.debug.print("IOElement "+method+" request");
	if (typeof(url)=="string") this._requests[id] = [url,data,fn,method,null,null,cargo];
	else if (method=="get") {
		for (i=0;i<url.length;i++) {  // support loading several files, attach handler to last file
			src = url[i];
			if (i<url.length-1) this._requests[id] = [src,null,null,method,null,null,cargo];
			else this._requests[id] = [src,data,fn,method,null,null];
		}
	}

	l=this._requestList.length;
	this._requestList[l] = id;
	if (this._created) this._setRequestTimeout(20);
	return id;
};
p._doRequest = function(id) {
	if (this.isBusy()) {this._setRequestTimeout(200,id);return;}
	else {
		if (this._requestIndex<this._requestList.length-1 || id) {
			if(!id){ // <- direct request - used by the retry() method
				this._requestIndex++;
				id = this._requestList[this._requestIndex];
			}
			var i,t,cont=false;
			var r = this._requests[id];
			if(r) {
				var url = r[0];
				var data = r[1];
				var fn = r[2];
				var method = r[3];
				var elm = this._getFreeElm();
				cont=(elm)? true:false;
			}
			if(!cont) {
				this._setRequestTimeout(200,id);
				return;
			}

			r[4]=this._elmThread;
			if (url.indexOf('http')!=0) {
				if (url.substr(0,1)=='/') url = 'http://'+dynapi.frame.document.domain+url;
				else url = dynapi.documentPath+url;
			}

			url += (url.indexOf('?')==-1)? '?' : '&';
			url += 'IORequestID='+id+'&IOElementID='+this.id+'&IOMethod='+method;

			t=this+'._notify("'+id+'","'+url+'",false)';

			// add eval code to transaction records
			if(!dynapi.ua.ns4) this._transactions[id]=[0,t];

			r[5] = window.setTimeout(t,this.failTime);

			// reset document - this will help to prevent cross-domain access errors
			if (dynapi.ua.def) elm.document.location.href = 'about:blank';

			if (method=="get" || (dynapi.ua.ns4 && !this._winXFrames)) {
				if (data) {
					for (i in data) {
						if(i) url += '&'+i+'='+escape(data[i]);
					}
				}
				if (this._winXFrames) elm.location.href=url;
				else if (dynapi.ua.ns4) elm.src = url;
				else elm.document.location.href = url;
			}else if(method=='upload') {
				var f=data;
				f.action=url;
				f.encoding='multipart/form-data';
				f.method='post';
				f.target=this._elmThread;
				f.submit();
			}else {
				var str = '<html><body><form name="ioDataForm" action="'+url+'" method="post" enctype="application/x-www-form-urlencoded">';
				if (data) {
					for (i in data) {
						if(i) str += '<input name="'+i+'" type="hidden">';
					}
				}
				str += '</form></body></html>';

				elm.document.open();
				elm.document.write(str);
				elm.document.close();

				var f = elm.document.forms['ioDataForm'];
				if (!f) return alert("IOElement Error: no form element found");
				if (f && data) {
					for (i in data) {
						if(i) f[i].value = data[i];
					}
				}
				f.submit();
			}

 			// begin transaction - data sent but awaiting reply
 			// to-do work on a way to detech if caller is in the same domain as
			if(!dynapi.ua.ns4) {
				elm.document._tranState="begin";
				this._monitorTransactions();
			}
			this.invokeEvent("request");
		}
	}
};
p._clearScope=function(){
	var doc=this.getScope().document;
	if(doc){doc.open();doc.write('');doc.close()}
};
p._getFreeElm= function(){
	for (var i in this._elmBusy){
		if (this._elmBusy[i]==false){
			this._elmThread=i;this._elmBusy[i]=true;
			return this.getScope();
		}else if(this._singleThread) break;
	}
};
p._getRandomID = function(){
	var id = Math.random()+'';
	return 'io'+id.substring(2);
};
p._monitorTransactions = function(){
	var c,r,tr,id,elm;
	for (id in this._transactions){
		r=this._requests[id];
		tr=this._transactions[id];
		if(r && this._elmBusy[r[4]]) {
			elm=this.getScope(r[4]);
			if(elm && elm.document && !elm.document._tranState){
				// document completed without proper response from server
				tr[0]+=1; // counter.
				if(tr[0]>=3){
					//three strikes and you're out!
					eval(tr[1]);
				}
			}
		}
	}
	if(id) window.setTimeout(this+'._monitorTransactions()',1000);
};
p._notify = function(id, url, success) {
	var fn,req=this._requests[id]; if(!req)return;
	var s = (success!=null)? success : true;
	// delete transaction record
	delete this._transactions[id];
	if (!this._elmBusy[req[4]] && success) {
		dynapi.debug.print('IOElement Error: '+id+' '+this._elmID+' '+url);
		return;
	}
	clearTimeout(req[5]);
	this._elmThread=req[4];
	fn = req[2]; // callback function
	if(!s) this._retryID=id; else this._retryID='';
	this._cargoID=id;
	if (fn) {
		var r,e = new DynEvent("load",this);
		if(typeof(fn)=='function') r=fn(e, s);
		else r=eval(fn);
		// cancels server response and preserve request object
		if(r==false) {
			s=false;
			this._retryID=id;
		}
	}else{
		this.invokeEvent("response",null,s);
	}
	this._cargoID='';
	if(s && id!=this._retryID) delete this._requests[id];
	else if(this._hidden) this._clearScope();
	this._elmBusy[req[4]] = false;
	// release document - prevent incomplete progressbar in ie
	if(dynapi.ua.ie) location.href = "javascript:void (document.close())";
	this._doRequest();
};
p._setRequestTimeout=function(interval,id){
	var evl=this+'._doRequest('+((id)? "'"+id+"'":'')+')';
	return window.setTimeout(evl,interval);
};
// Helper Methods -------------------------
IOElement.getSharedIO=function(useXFrames){ // Returns a Shared instance of the IOElement object
	if(!IOElement.ShareIO) IOElement.ShareIO=new IOElement(1,useXFrames);
	return IOElement.ShareIO;
};
IOElement.notify = function(elm, fn, success) {  // ds: added success parameter to nicely relay server generated error messages
	if (elm) {
		var url, id;
		if (dynapi.ua.ns4 && elm.src) url = elm.src;
		else if (dynapi.ua.ns4 && elm.location) url = elm.location.href;
		else url = elm.document.location.href;
		if (url) {
			elm.args = dynapi.functions.getURLArguments(url);
			var id = elm.args["IORequestID"];
			var obj = DynObject.all[elm.args["IOElementID"]];
			if (obj!=null && id!=null) {
				 // transaction completed - server has respond sucessfully
				elm.document._tranState="complete";
				elm.onload = function() {
					if (fn) fn(obj); // send obj fn - rmo
					obj._notify(id,url, success);  // ds: success
				};
				return obj;
			}
			else {
				return false;
			}
		}
	}
	return null;
};
IOElement.URLEncode = function (d){
	d=d.replace(/\s/g,'+').replace(/\%/g,'%25').replace(/\=/g,'%3D');
	d=d.replace(/\&/g,'%26').replace(/\n/g,'%0A').replace(/\r/g,'%0D');
	d=d.replace(/\#/g,'%23').replace(/\\/g,'%5C');
	return d;
};
