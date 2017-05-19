/*
   DynAPI Distribution
   LoadPanel Class
   
   The DynAPI Distribution is distributed under the terms of the GNU LGPL license.

   Requirements:
	dynapi.api.Dynlayer
*/

function LoadPanel(url) {
	this.DynLayer = DynLayer;
	this.DynLayer();

	this._resizeH=true;
	this._resizeW=false;
	this._elmID = this.id+'_loadElm';
	this._busy = true;
	if (url) this._url = url;
	this.setOverflow('hidden');

	this.marginWidth = 5;
	this.marginHeight = 5;

	var lp = this;
	this.historyIndex = -1;
	this.history = [];
	this.history.back = function() {
		if (!lp._busy && lp.historyIndex>0) {
			lp.historyIndex--;
			lp.reload();
		}
	};
	this.history.forward = function() {
		if (!lp._busy && lp.historyIndex<lp.history.length-1) {
			lp.historyIndex++;
			lp.reload();
		}
	};

	this.onPreCreate(LoadPanel.PreCreateEvent);
	this.onCreate(LoadPanel.CreateEvent);
};
LoadPanel.PreCreateEvent = function(e) {
	if (dynapi.ua.ns4) this.html = '<layer left=0 top=0 width='+this.w+' height='+this.h+' name="'+this._elmID+'" visibility="inherit"></layer>';
	else {
		// Opera v7.11 requires an IFrame's src be set before it's accessible - pixel.gif is a 1x1 transparent gif
		var html = '<iframe name="'+this._elmID+'" src="'+dynapi.library.path+'gui/images/pixel.gif" style="width:0px; height:0px; visibility:hidden;"></iframe>';  //visibility: hidden; display: none;
		this._loadlyr = new DynLayer(html,0,0,0,0); // x,y,w,h required by some browsers
		this._loadlyr.setVisible(false);
		dynapi.document.addChild(this._loadlyr);
	}
};
LoadPanel.CreateEvent = function(e) {
	if (dynapi.ua.ns4) this._loadElm = this.doc.layers[0];
	else this._loadElm = dynapi.frame.frames[this._elmID];
	this._busy = false;
	if (this._url) setTimeout(this+'.setURL("'+this._url+'")', 10);
};

var p = LoadPanel.prototype = new DynLayer;
p._DynLayer_setSize = DynLayer.prototype.setSize;
p.setSize = function(w,h) {
	var r = this._DynLayer_setSize(w,h);
	//if (r && this._created && !this._isReloading && this.autoH && this.url) this.reload();
};
p.getURL=function() {
	return this.history[this.historyIndex];
};
p.setURL = function(url, skipHistory) {
	if (typeof(url)=='string') {
		if (!this._created || this._busy) this._url = url;
		else {
			if (skipHistory!=true) {
				this.historyIndex++;
				this.history[this.historyIndex] = url;
				this.history.length = this.historyIndex+1;
			}
			
			var id = Math.random()+'';
			url += (url.indexOf('?')==-1)? '?' : '&';
			url += 'rand='+id.substring(2)+'&lpElementID='+this.id;
			
			this._busy = true;
			if (dynapi.ua.ns4) this._loadElm.src = url;
			else this._loadElm.document.location.href = url;
		}
	}
};
p.reload = function() {
	this.setURL(this.history[this.historyIndex], true);
};
p.clear = function() {
	this._loadElm.document.write();
	this._loadElm.document.close();
	if (!dynapi.ua.ns4) this.setHTML('');
	this.historyIndex = -1;
	this.history = [];
};
p._notify = function() {
	this._busy = false;
	if (dynapi.ua.ns4) {
		var elm = this._loadElm;
		var h = elm.document.height;
		elm.clip.height = h;
		elm.clip.width = this.w;
		this.setHeight(h);
		setTimeout(this+'.invokeEvent("change")',1);
	}
	else {
		var html = this._loadElm.document.body.innerHTML;
		if (html) {
			// remove js scripts - (.|\s)*? is used to match all characters including multiple lines
			html=html.replace(/\<script(.|\s)*?\>(.|\s)*?\<\/script\>/ig,''); 
			this.setHTML(html);
			setTimeout(this+'._notify2()',10);  // ie/mac needs an extra ms to properly get content height
		}
	}
};
p._notify2 = function() {
	var h = this.getContentHeight();
	if (!h) setTimeout(this+'._notify2()',200);
	this.setHeight(h);
	var bg = this._loadElm.document.bgColor;
	if (bg) this.setBgColor(bg);
	setTimeout(this+'.invokeEvent("change")',1);
};
LoadPanel.notify = function(elm) {
	var url,id,obj;
	if (dynapi.ua.ns4) url = elm.src;
	else url = elm.document.location.href;
	
	var args = dynapi.functions.getURLArguments(url);
	obj = DynObject.all[args["lpElementID"]];
	
	if (obj!=null) {
		elm.onload = function() {
			setTimeout(obj+'._notify("'+id+'","'+url+'")',100);
		};
		return obj; // returns loadpanel to the page
	}
	else {
		return false; // error
	}
};
