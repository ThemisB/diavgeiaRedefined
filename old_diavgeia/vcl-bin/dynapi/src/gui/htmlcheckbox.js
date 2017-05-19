/*
	DynAPI Distribution
	HTMLCheckBox Class

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: HTMLComponent
*/

function HTMLCheckBox(css,value,state,title,elmName){
	this.HTMLComponent = HTMLComponent;
	this.HTMLComponent(css);

	this._elmId = elmName||(this.id+'CHK');
	this._title = title||'';
	this._value = value||'';
	this._state = (state)? true:false;
	this._defEvtResponse = true;
};
var p = dynapi.setPrototype('HTMLCheckBox','HTMLComponent');
// Methods
p._oldHCCBEvt = HTMLComponent.prototype._e;
p._getDSValue = function(){ // DataSource functions
	if(this.getElm()) return (this.elm.checked)? this.getValue():null;
};
p._setDSValue = function(d){
	if(d==this._value) this.setState(true);
	else this.setState(false);
};
p._e = function(evt,elm,arg){
	if(evt=='click') this._state=elm.checked;
	return this._oldHCCBEvt(evt,elm,arg);
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
	var evt,value=this._value||'';
	var sel = (this._state)? ' checked ':'';
	evt = this._generateInlineEvents(this);
	return '<input type="checkbox" class="'+this._class+'" id="'+this._elmId+'" name="'+this._elmId+'" value="'+value+'" '
	+sel+evt+' title="'+this._title+'" />';
};
p.getState = function(){
	return (this.getElm())? this.elm.checked:this._state;
};
p.getValue = function() {
	return (this.getElm())? this.elm.value:this._value;
};
p.setElementName = function(t){
	if(t) this._elmId = t;
};
p.setState = function(b) {
	this._state=(b) ? true:false;
	if(this.getElm()) this.elm.selected=this._state;
};
p.setValue = function(v) {
	this._value=v||'';
	if(this.getElm()) this.elm.value=v;
};
