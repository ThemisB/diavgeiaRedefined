/*
	DynAPI Distribution
	HTMLContainer Class

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: HTMLComponent
*/

function HTMLContainer(css,html,w,h){
	this.HTMLComponent = HTMLComponent;
	this.HTMLComponent(css);	
	
	this.w=w; this.h=h;
	this.html=html||'';
};
var p = dynapi.setPrototype('HTMLContainer','HTMLComponent');
p._ns4IPad='<img src="'+dynapi.library.path+'gui/images/pixel.gif" width="0" height="0">';
p._assignElm = function(elm){
	if(!this.parent) return;
	else if(!this.parent._created) return;
	var id=this.id+'HTC';
	var doc=this.parent.doc;
	if(!elm) {;	
		if(dynapi.ua.ie) elm=doc.all[id];
		else if(dynapi.ua.dom) elm=doc.getElementById(id);
		else if(dynapi.ua.ns4) {
			this._ns4ielm=doc.layers[id];
			elm =this._ns4ielm.document.layers[id+'L'];
			this._ns4ielm.clip.width=elm.document.width;
			this._ns4ielm.clip.height=elm.document.height;
		}
		if(!elm) return;
	}
	this.elm = elm;
	this.css = (dynapi.ua.ns4)? elm:elm.style;
	this.doc = elm.document;
	if(this.w==null) this.autoWidth();
	if(this.h==null) this.autoHeight();
};
p.autoHeight = function(){
	var h,ua=dynapi.ua
	if(ua.ns4) h=this.doc.height;
	else if(ua.ie||ua.opera) {
		if (dynapi.ua.platform=="mac") h=this.elm.offsetHeight;
		else h=parseInt(this.elm.scrollHeight);
	}
	else {
		var th = this.elm.style.height;
		this.elm.style.height = "auto";
		h = this.elm.offsetHeight;
		this.elm.style.height = th;
	}
	this.h=h;
	if(ua.ns4) this.css.clip.height=h;
	else {
		this.css.height = h+'px';
		this.css.clip.height=h+'px';
	}
};
p.autoWidth = function(){
	var w,ua=dynapi.ua
	if(ua.ns4) w=this.doc.width;
	else if(ua.ie||ua.opera) {
		if (dynapi.ua.platform=="mac") w=this.elm.offsetWidth;
		else w=parseInt(this.elm.scrollWidth);
	}
	else {
		var tw = this.elm.style.width;
		this.elm.style.width = "auto";
		w = this.elm.offsetWidth;
		this.elm.style.width = tw;
	}
	this.w=w;
	if(ua.ns4) this.css.clip.width=w;
	else {
		this.css.clip.width=w+'px';
		this.css.width = w+'px';
	}
};
p.getInnerHTML = function(){
	var clip='';
	var h,html = this.html;
	var evts =this._generateInlineEvents(this);
	if(dynapi.ua.ns4) {
		if(this.w==null) html='<nobr>'+html+'</nobr>';
		if (this.w!=null && this.h!=null) clip=' clip="0,0,'+((this.w>=0)?this.w:0)+','+((this.h>=0)?this.h:0)+'"';
		h='\n<ilayer visibility="inherit" id="'+this.id+'HTC" '
		+((this.w)? ' width="'+this.w+'"':'')
		+((this.h)? ' height="'+this.h+'"':'')
		+'><layer '+evts+' class="'+this._class+'" id="'+this.id+'HTCL" '+clip+'>'+this._ns4IPad+html+'</layer></ilayer>';
		/* NS4 iLayer seems to be having a problem when you're trying to update the content of the layer 
		so a layer was used to support document.write() method after page load.
		I've also noticed that at times <layer> will not display a <table> it's nested inside another table. 
		for example <table><tr><td><ilayer><layer><table><tr><td>Content</td></tr></table></layer></ilayer></td></tr></table>
		the _ns4IPad will keep things in tact. *sigh* - NS4!!!! */
	}
	else {
		if (this.w!=null && this.h!=null) clip=' clip:rect(0px '+this.w+'px '+this.h+'px 0px);';		
		h='<div class="'+this._class+'" id="'+this.id+'HTC" '+evts+' style="position:relative;overflow:hidden;'
		+((this.w)? ' width:'+this.w+'px;':'')
		+((this.h)? ' height:'+this.h+'px;':'')
		+clip+'">'+html+'</div>';
	}
	return h;
};
p.getHTML = function(html) {return this.html};
p.setHTML = function(html) {
	if(this.html==html) return;
	this.html=html
	if(this.getElm()){
		if(dynapi.ua.ie||dynapi.ua.opera) this.elm.innerHTML=html; // ok?
		else if(dynapi.ua.ns4) {
			var doc=this.doc;
			if(this.w==null) html='<nobr>'+html+'</nobr>';
			doc.open(); doc.write(this._ns4IPad+html); doc.close();
			this._ns4ielm.clip.width=doc.width;
			this._ns4ielm.clip.height=doc.height;
		}
		else{
			var elm = this.elm;
			elm.innerHTML = html;		
			var sTmp=(this.w==null)? '<nobr>'+this.html+'</nobr>':this.html;
			while (elm.hasChildNodes()) elm.removeChild(elm.firstChild);
			var r=elm.ownerDocument.createRange();
			r.selectNodeContents(elm);
			r.collapse(true);
			var df=r.createContextualFragment(sTmp);
			elm.appendChild(df);
		}
	}
};