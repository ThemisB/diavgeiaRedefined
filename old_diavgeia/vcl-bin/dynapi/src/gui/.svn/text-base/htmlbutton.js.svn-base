/*
	DynAPI Distribution
	HTMLButton Class

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: HTMLComponent
*/

function HTMLButton(css,caption,title,elmName){
	this.HTMLComponent = HTMLComponent;
	this.HTMLComponent(css);
	
	this._elmId = elmName||(this.id+'BTN');
	this._title=title||'';
	this._caption=caption||'';
	this._defEvtResponse = true;
};
var p = dynapi.setPrototype('HTMLButton','HTMLComponent');
// Methods
p._getDSValue = function(){return this._caption}; // DataSource functions
p._setDSValue = function(d){this.setCaption(d)};
p._assignElm = function(elm){
	if(!this.parent) return;
	else if(!this.parent._created) return;
	var doc=this.parent.doc;
	if(!elm){
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
	var evt = this._generateInlineEvents(this);
	var text=this._caption||'';
	return '<input type="button" class="'+this._class+'" id="'+this._elmId+'" name="'+this._elmId+'" value="'+text+'" '
	+evt+' title="'+this._title+'" />';
};
p.getCaption = function() {
	return (this.getElm())? this.elm.value:this._text;
};
p.setCaption = function(t) {
	var elm = this.getElm();
	this._caption = t||'';
	if(elm) elm.value=t;
};
p.setElementName = function(t){
	if(t) this._elmId = t;
};
