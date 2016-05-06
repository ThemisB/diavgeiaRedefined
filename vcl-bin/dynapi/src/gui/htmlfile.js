/*
	DynAPI Distribution
	HTMLFile Class

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: HTMLComponent
*/

function HTMLFile(css,hidden,size,title,elmName){
	this.HTMLComponent = HTMLComponent;
	this.HTMLComponent(css);

	this._elmId = elmName||(this.id+'FILE');
	this._size = size||20;
	this._title = title||'';
	this._hidden = (hidden)? true:false;
	this._defEvtResponse = true;
};
var p = dynapi.setPrototype('HTMLFile','HTMLComponent');
p._inlineEvents+=' onkeypress="return htc._e(\'keypress\',this,event);" '
+' onkeyup="return htc._e(\'keyup\',this,event);" '
+' onkeydown="return htc._e(\'keydown\',this,event);" ';
// Methods
p._assignElm = function(elm){
	if(!this.parent) return;
	else if(!this.parent._created) return;
	var doc=this.parent.doc;
	if(!elm) {
		if(dynapi.ua.ie) elm=doc.all[this._elmId];
		else if(dynapi.ua.dom) elm=doc.getElementById(this._elmId);
		else if(dynapi.ua.ns4){
			for(i=0;i<doc.forms.length;i++){
				elm=doc.forms[i][this._elmId];
				if(elm) break;
			}
		}
		if(!elm) return;
	}
	this.elm = elm;
	this.css = (dynapi.ua.ns4)? elm:elm.style;
	this.doc = this.parent.doc;
};
p.getInnerHTML = function(){
	var style,evt,text=this._text||'';
	evt = this._generateInlineEvents(this);
	style=(this._hidden)? 'style="display:none"':'';
	return '<input type="file" class="'+this._class+'" id="'+this._elmId+'" name="'+this._elmId+'" size="'+this._size+'"'
	+style+evt+' title="'+this._title+'" />';
};
p.getFileName = function(){
	return (this.getElm())? this.elm.value:this._text
};
p.browse = function() {
	if(this.getElm()) this.elm.click();
};
p.setElementName = function(t){
	if(t) this._elmId = t;
};
