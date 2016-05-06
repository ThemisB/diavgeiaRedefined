/*
	DynAPI Distribution
	CheckBox Component by Raymond Irving (http://dyntools.shorturl.com)

	The DynAPI Distribution is distributed under the terms of the GNU LGPL license.
	
	Requires: StyleManager, CheckBoxStyle (Optional)
*/

function CheckBox(itext,x,y,w,h,value,checked,style) {
	this.DynLayer=DynLayer;
	this.DynLayer(null,x,y,w,h);

	this._value=value||'';
	this._checked=checked||false;
	
	this.setCaption(itext);
	this.setStyle(style||'CheckBox');
};
/* Prototype */
var p=dynapi.setPrototype('CheckBox','DynLayer');
// Private
p._setDSValue = function(b){
	this.setSelected(b);
};
p._getCapHTML = function(){
	var c = this._caption;
	var ff=this.getStyleAttribute('fontFamily');
	var fs=this.getStyleAttribute('fontSize');
	var fb=this.getStyleAttribute('fontBold');
	var fi=this.getStyleAttribute('fontItalics');
	var fu=this.getStyleAttribute('fontUnderline');
	var fc=(this._disabled)? this.getStyleAttribute('disableColor'):this.getStyleAttribute('foreColor');
	return Styles.createText(c,ff,fs,fb,fi,fu,fc);
};
// Public
p.getCaption=function(){return this._iText};
p.getValue=function() {return this._value;};
p.isChecked=function() {return this._checked;}
p.setCaption=function(itext,nowrap,fn,fs,fc){
	if(!itext) itext='';
	this._iText=itext;
	if(itext && itext.getHTML) itext=itext.getHTML();	
	this._nowrap = (nowrap==null)? true:nowrap;
	this._caption = itext;	
	if(this._created) this.renderStyles('caption');
};
p.setSelected=function(b) {
	var img;
	if (this._checked==b) return; 
	this._checked=b;
	if (this._checked && this._created) img = this.getStyleAttribute('imageOn');
	else img = this.getStyleAttribute('imageOff');
	if(img) this.doc.images[this.id+'imgchk'].src = img.src;
	this.invokeEvent('change');
};
p.setValue = function(d) {
	this._value=d;
};
