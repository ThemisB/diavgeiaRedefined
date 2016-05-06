/*
   DynAPI Distribution
   RadioButton Component by Raymond Irving (http://dyntools.shorturl.com)

   The DynAPI Distribution is distributed under the terms of the GNU LGPL license.

   Requires: StyleManager, RadioButtonStyle (Optional)
*/

function RadioButton(itext,x,y,w,h,value,selected,style) {
	this.DynLayer=DynLayer;
	this.DynLayer(null,x,y,w,h);

	this._value=value||'';
	this._selected=selected||false;

	this.setCaption(itext);
	this.setStyle(style||'RadioButton');
};

/* Prototype */
var p=dynapi.setPrototype('RadioButton','DynLayer');
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
p.getCaption = function(){return this._iText;};
p.getValue = function() {return this._value;};
p.isChecked = function() {return this._selected;};
p.setCaption = function(itext,nowrap,fn,fs,fc){
	if(!itext) itext='';
	this._iText=itext;
	if(itext && itext.getHTML) itext=itext.getHTML();	
	this._nowrap = (nowrap==null)? true:nowrap;
	this._caption = itext;
	if(this._created) this.renderStyle('caption');
};
p.setSelected = function(b,meOnly) {
	var i,ch,img;
	if (this._selected==b) return;
	if (this.parent!=null && !meOnly){
		for (i in this.parent.children) {
			ch=this.parent.children[i];
			if (ch.id!=this.id && ch.isClass('RadioButton')){
				ch.setSelected(false,true)
			}
		}
	}
	this._selected=b;
	if (this._selected && this._created) img = this.getStyleAttribute('imageOn');
	else img = this.getStyleAttribute('imageOff')
	if(img) this.doc.images[this.id+'imgrad'].src = img.src
	this.invokeEvent('change');
};
p.setValue = function(d) {
	this._value=d;
};

