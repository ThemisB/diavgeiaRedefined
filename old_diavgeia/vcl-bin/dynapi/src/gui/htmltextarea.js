/*
	DynAPI Distribution
	HTMLTextArea Class

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: HTMLComponent
*/

function HTMLTextArea(css,text,cols,rows,maxLength,title,elmName){
	this.HTMLComponent = HTMLComponent;
	this.HTMLComponent(css);
	
	this._elmId = elmName||(this.id+'TXTA');
	this._cols = cols||20;
	this._rows = rows||5;
	this._title = title||'';
	this._text = text||'';
	this._wrap = true;
	this._maxLen = maxLength;
	this._defEvtResponse = true;
	// set max length
	if(maxLength>0 && this._text.length>maxLength) {
		this._text = this._text.substr(0,maxLength)
	}
};
var p = dynapi.setPrototype('HTMLTextArea','HTMLComponent');
p._inlineEvents+=' onkeypress="return htc._e(\'keypress\',this,event);" '
+' onkeyup="return htc._e(\'keyup\',this,event);" '
+' onkeydown="return htc._e(\'keydown\',this,event);" '
+' onchange="return htc._e(\'change\',this,event);" ';
// Methods
p._oldHCTAEvt = HTMLComponent.prototype._e;
p._getDSValue = function(){return this._text}; // DataSource functions
p._setDSValue = function(d){this.setText(d)};
p._e = function(evt,elm,arg){
	// set max length
	if(this._maxLen>0 && elm.value.length>this._maxLen){
		this._text = elm.value.substr(0,this._maxLen);
		elm.value = this._text;
	}
	var rt = this._oldHCTAEvt(evt,elm,arg);
	if(dynapi.ua.ns4 && evt=='focus' && this._readonly) this.elm.blur();
	return rt;	
};
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
	var ua = dynapi.ua;
	var wrap,evt,text=this._text||'';
	var readstate = (this._readonly)? ' readonly ':'';
	if(ua.ns4) wrap=(!this._wrap)? ' wrap="off" ':' wrap="soft" ';
	else if(ua.ie) wrap=(!this._wrap)? ' wrap="off" ':' wrap="virtual" ';
	else wrap=(!this._wrap)?' style="white-space:nowrap;" ':'';
	evt = this._generateInlineEvents(this);
	return '<textarea class="'+this._class+'" id="'+this._elmId+'" name="'+this._elmId+'" cols="'+this._cols+'" rows="'+this._rows+'" '
	+wrap+readstate+evt+' title="'+this._title+'">'+text+'</textarea>';
};
p.getText = function() {
	return (this.getElm())? this.elm.value:this._text
};
p.setElementName = function(t){
	if(t) this._elmId = t;
};
p.setReadOnly = function(b){
	this._readonly = b;
	if(this.getElm()) this.elm.readonly=(b)? 'readonly':'';
};
p.setText = function(t) {
	var elm = this.getElm();
	this._text = t||'';
	if(elm) elm.value=this._text;
};
p.setWrap = function(b){
	var ua = dynapi.ua;
	this._wrap = b;
	if(this.getElm()) {
		if(ua.ns4) this.elm.wrap = (!b)? 'off':'soft';
		else if(ua.ie) this.elm.wrap = (!b)? 'off':'virtual';
		else this.css.whiteSpace = (!b)? 'nowrap':'normal';
	}
};
