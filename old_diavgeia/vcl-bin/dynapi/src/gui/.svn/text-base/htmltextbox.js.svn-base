/*
	DynAPI Distribution
	HTMLTextBox Class

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: HTMLComponent
*/

function HTMLTextBox(css,text,size,maxLength,mask,title,elmName){
	this.HTMLComponent = HTMLComponent;
	this.HTMLComponent(css);
	
	this._elmId = elmName||(this.id+'TXT');
	this._size = size||20;
	this._title = title||'';
	this._mask = (mask)? true:false;
	this._text = text||'';
	this._maxLen = maxLength;
	this._defEvtResponse = true;
};
var p = dynapi.setPrototype('HTMLTextBox','HTMLComponent');
p._inlineEvents+=' onkeypress="return htc._e(\'keypress\',this,event);" '
+' onkeyup="return htc._e(\'keyup\',this,event);" '
+' onkeydown="return htc._e(\'keydown\',this,event);" '
+' onchange="return htc._e(\'change\',this,event);" ';
// Methods
p._oldHCTBEvt = HTMLComponent.prototype._e;
p._getDSValue = function(){return this._text}; // DataSource functions
p._setDSValue = function(d){this.setText(d)};
p._e = function(evt,elm,arg){
	var rt = this._oldHCTBEvt(evt,elm,arg);
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
	var max,evt,text=this._text||'';
	var readstate = (this._readonly)? ' readonly ':'';
	evt = this._generateInlineEvents(this);
	max = (this._maxLen)? ' maxlength="'+this._maxLen+'" ':'';
	return '<input type="'+((!this._mask)? 'text':'password')+'" class="'+this._class+'" id="'+this._elmId+'" name="'+this._elmId+'" size="'+this._size+'" value="'+text+'" '
	+readstate+max+evt+' title="'+this._title+'" />';
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
	this._text= t||'';
	if(elm) elm.value=this._text;
};
